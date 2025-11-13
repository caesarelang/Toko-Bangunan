<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Semua produk
        $products = Product::all();

        // Produk terlaris bulan ini
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) use ($startOfMonth, $endOfMonth){
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('status', 'completed');
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        return view('Owner.Products.index', compact('products', 'topProducts'));
    }
}
