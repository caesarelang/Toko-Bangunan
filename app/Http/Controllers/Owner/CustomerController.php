<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        // Semua customer
        $customers = User::where('role', 'customer')->get();

        // Top customer berdasarkan total order
        $topCustomers = User::where('role', 'customer')
            ->withCount(['orders as total_orders' => function($q){
                $q->where('status', 'completed');
            }])
            ->withSum(['orders as total_spent' => function($q){
                $q->where('status', 'completed');
            }], 'total_price')
            ->orderByDesc('total_orders')
            ->take(10) // top 10
            ->get();

        return view('Owner.Customers.index', compact('customers','topCustomers'));
    }
}
