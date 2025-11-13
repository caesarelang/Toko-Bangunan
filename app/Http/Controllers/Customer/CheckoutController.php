<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Hitung total dari cart
        $total = $cart->items->sum(fn($item) => $item->price * $item->quantity);

        // 1️⃣ Buat order utama
        $order = $user->orders()->create([
            'status'       => 'pending',
            'total_price'  => $total,
            'latitude'     => $request->latitude ?? $user->latitude,
            'longitude'    => $request->longitude ?? $user->longitude,
        ]);

        // 2️⃣ Simpan semua item cart ke order_items
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->price,
            ]);

            // Kurangi stok produk
            $item->product->decrement('stock', $item->quantity);
        }

        // 3️⃣ Kosongkan cart
        $cart->items()->delete();

        // 4️⃣ Buat invoice ke Xendit
        $apiKey = config('xendit.secret_key');
        $config = Configuration::getDefaultConfiguration()->setApiKey($apiKey);
        $apiInstance = new InvoiceApi(null, $config);

        $params = new CreateInvoiceRequest([
            'external_id'          => 'order-' . $order->id,
            'payer_email'          => $user->email,
            'description'          => 'Pembayaran pesanan #' . $order->id,
            'amount'               => $order->total_price,
            'success_redirect_url' => route('customer.payment.success', ['order' => $order->id]),
        ]);

        $invoice = $apiInstance->createInvoice($params);

        // 5️⃣ Update order dengan info Xendit
        $order->update([
            'xendit_id'   => $invoice['id'],
            'payment_url' => $invoice['invoice_url'],
        ]);

        // 6️⃣ Redirect ke halaman pembayaran Xendit
        return redirect($invoice['invoice_url']);
    }
    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        $user = auth()->user();

        // 1️⃣ Update status order
        $order->update(['status' => 'processing']);

        // 2️⃣ Buat transaction
        $transaction = $user->transactions()->create([
            'total_amount'   => $order->total_price,
            'status'         => 'paid',             // karena sudah sukses
            'payment_method' => 'transfer',           // bisa diubah sesuai payment method
        ]);

        // 3️⃣ Buat transaction items dari order items
        foreach ($order->items as $item) {
            $transaction->items()->create([
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->price,
            ]);
        }

        // 4️⃣ Redirect dengan notifikasi sukses
        return redirect()
            ->route('customer.orders')
            ->with('success', 'Pembayaran berhasil! Pesananmu telah dikonfirmasi.');
    }


}
