<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'total_amount', 'status', 'payment_method', 'created_at', 'updated_at'];
    
   public function user()
{
    return $this->belongsTo(User::class);
}

public function items()
{
    return $this->hasMany(TransactionItem::class);
}

public function invoice()
{
    return $this->hasOne(Invoice::class);
}
 //
}
