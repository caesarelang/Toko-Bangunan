<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Total pemasukan bulan ini
        $totalRevenue = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'completed')
            ->sum('total_price');

        // Total order bulan ini
        $totalOrders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Produk terlaris bulan ini
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) use ($startOfMonth, $endOfMonth){
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                  ->where('status', 'completed');
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Top customers bulan ini berdasarkan jumlah order
        $topCustomersOrders = User::where('role', 'customer')
            ->withCount(['orders as total_orders' => function($q) use ($startOfMonth, $endOfMonth){
                $q->where('status','completed')
                  ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            }])
            ->orderByDesc('total_orders')
            ->take(5)
            ->get();

        // Top customers bulan ini berdasarkan total belanja
        $topCustomersRevenue = User::where('role', 'customer')
            ->withSum(['orders as total_spent' => function($q) use ($startOfMonth, $endOfMonth){
                $q->where('status','completed')
                  ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            }], 'total_price')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();

        return view('Owner.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'topProducts',
            'topCustomersOrders',
            'topCustomersRevenue'
        ));
    }
}
