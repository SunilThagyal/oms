<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
    ];

    // Define the relationship to the Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Define the relationship to the Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
