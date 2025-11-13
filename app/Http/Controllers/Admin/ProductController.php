<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProductController extends Controller
{    
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('Admin.Products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('Admin.Products.create', compact('categories'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload ke Supabase Storage
    $file = $request->file('image');
    $filename = 'product_' . time() . '.' . $file->getClientOriginalExtension();

    // Upload pakai HTTP client bawaan Laravel
    $response = \Http::withHeaders([
        'apikey' => env('SUPABASE_KEY'),
        'Authorization' => 'Bearer ' . env('SUPABASE_KEY'),
    ])->attach(
        'file',
        file_get_contents($file),
        $filename
    )->post(env('SUPABASE_URL') . '/storage/v1/object/' . env('SUPABASE_BUCKET') . '/' . $filename);

    if (!$response->successful()) {
        return back()->withErrors(['image' => 'Gagal upload ke Supabase Storage']);
    }

    // URL publik gambar
    $imageUrl = env('SUPABASE_URL') . '/storage/v1/object/public/' . env('SUPABASE_BUCKET') . '/' . $filename;

    // Simpan produk ke database
    Product::create([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'stock' => $validated['stock'],
        'category_id' => $validated['category_id'],
        'image' => $imageUrl,
    ]);

    return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
}


    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('Admin.Products.edit', compact('product', 'categories'));
    }
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $product = Product::findOrFail($id);

    // Jika ada gambar baru
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

        $bucket = env('SUPABASE_BUCKET', 'products');
        $supabaseUrl = env('SUPABASE_URL');
        $apiKey = env('SUPABASE_KEY');

        // Upload ke Supabase
        $response = Http::withHeaders([
            'apikey' => $apiKey,
            'Authorization' => 'Bearer ' . $apiKey,
        ])->attach(
            'file', file_get_contents($image), $filename
        )->post("$supabaseUrl/storage/v1/object/$bucket/$filename");

        if ($response->failed()) {
            return back()->withErrors(['image' => 'Gagal upload gambar ke Supabase.']);
        }

        // Simpan URL publik
        $validated['image'] = "$supabaseUrl/storage/v1/object/public/$bucket/$filename";
    }

    $product->update($validated);

    return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus.');
    }
}
