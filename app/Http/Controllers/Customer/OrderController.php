<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrderController extends Controller
{
public function index(Request $request)
{
    $user = auth()->user();
    $ordersQuery = $user->orders()->with('items.product');

    // Filter berdasarkan status
    if ($request->has('status') && $request->status != '') {
        $ordersQuery->where('status', $request->status);
    }

    $orders = $ordersQuery->orderBy('created_at', 'desc')->get();

    return view('Customer.Orders.index', compact('orders'));
}

    public function cancel($id)
{
    $order = Order::with('items.product')->findOrFail($id);

    // Pastikan hanya pemilik order yang bisa batalkan
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    // Cegah pembatalan kalau sudah selesai
    if ($order->status === 'completed') {
        return redirect()->back()->with('error', 'Order already completed and cannot be canceled.');
    }

    // // Kembalikan stok produk
    // foreach ($order->items as $item) {
    //     $product = $item->product;
    //     $product->increment('stock', $item->quantity);
    // }

    // Ubah status order jadi 'canceled'
    $order->update(['status' => 'cancellation_requested']);

    return redirect()->back()->with('success', 'Order has been canceled and stock restored.');
}

}
