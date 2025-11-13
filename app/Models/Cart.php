<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    /**
     * Relasi ke user yang punya cart
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke item-item di dalam cart
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Hitung total harga seluruh item
     */
    public function getTotalPriceAttribute()
    {
        return $this->items->sum(fn($item) => $item->price * $item->quantity);
    }

    /**
     * Hitung total item (jumlah produk, bukan jenis)
     */
    public function getTotalQuantityAttribute()
    {
        return $this->items->sum('quantity');
    }
}
