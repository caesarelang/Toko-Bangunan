<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Orders by Status
        $ordersByStatus = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'delivering' => Order::where('status', 'delivering')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'cancellation_requested' => Order::where('status', 'cancellation_requested')->count(),
        ];

        // Total Revenue (completed / paid orders)
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');

        // Total Customers
        $totalCustomers = User::where('role', 'customer')->count();

        // Total Products
        $totalProducts = Product::count();

        return view('Admin.Dashboard.index', compact(
            'ordersByStatus',
            'totalRevenue',
            'totalCustomers',
            'totalProducts'
        ));
    }
}
