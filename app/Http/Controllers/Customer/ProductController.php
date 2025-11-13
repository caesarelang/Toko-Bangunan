<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();
        
        // Query dasar
        $query = Product::query();

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search berdasarkan nama atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Ambil data produk
        $products = $query->latest()->paginate(100)->withQueryString();

        return view('Customer.Products.index', compact('products', 'categories'));
    }
}
