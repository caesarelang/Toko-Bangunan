<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
public function index(Request $request)
{
    $query = Order::with('user');

    // Filter status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Filter tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59',
        ]);
    } elseif ($request->filled('start_date')) {
        $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
    } elseif ($request->filled('end_date')) {
        $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
    }

    $orders = $query->latest()->paginate(20)->withQueryString();

    return view('Admin.Orders.index', compact('orders'));
}



    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('Admin.Orders.show', compact('order'));
    }

public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:pending,processing,delivering,completed,cancelled,cancellation_requested'
    ]);

    $newStatus = $request->status;

    // Kalau status berubah ke cancelled dan sebelumnya belum cancelled
    if ($newStatus === 'cancelled' && $order->status !== 'cancelled') {
        foreach ($order->items as $item) {
            // Tambahkan kembali stok produk
            $item->product->increment('stock', $item->quantity);
        }
    }

    $order->update(['status' => $newStatus]);

    return redirect()->back()->with('success', 'Order status updated!');
}

}
