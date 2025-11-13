<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product')->firstOrCreate();

        return view('Customer.Carts.index', compact('cart'));
    }

public function add(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'nullable|integer|min:1'
    ]);

    $user = auth()->user();
    $cart = $user->cart()->firstOrCreate();
    $product = Product::findOrFail($request->product_id);
    $quantity = $request->quantity ?? 1;

    // ✅ Cek apakah produk sudah ada di cart
    $item = $cart->items()->where('product_id', $product->id)->first();

    if ($item) {
        // Hitung total quantity baru
        $newQuantity = $item->quantity + $quantity;

        // 🚫 Cegah melebihi stok
        if ($newQuantity > $product->stock) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock!');
        }

        $item->update(['quantity' => $newQuantity]);
    } else {
        // 🚫 Cek stok saat pertama kali ditambahkan
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock!');
        }

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);
    }

    return redirect()->back()->with('success', 'Product added to cart!');
}


public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $cartItem = CartItem::findOrFail($id);

    // Pastikan item milik user yang sedang login
    if ($cartItem->cart->user_id !== auth()->id()) {
        abort(403);
    }

    $product = $cartItem->product;

    // ✅ Cek apakah jumlah yang diinput melebihi stok
    if ($request->quantity > $product->stock) {
        return redirect()->back()->with('error', 'Quantity exceeds available stock!');
    }

    // Update quantity
    $cartItem->update(['quantity' => $request->quantity]);

    return redirect()->back()->with('success', 'Cart updated successfully!');
}


    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);

        // Pastikan item milik user yang sedang login
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed!');
    }
}
