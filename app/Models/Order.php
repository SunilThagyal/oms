<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'store_id',
        'status',
        'date',
    ];

    protected $appends = ['total_price', 'status_class'];
    // Define the relationship to the Customer (assuming it has a one-to-many relationship with orders)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id'); // Assuming the customer is a User
    }

    // Define the many-to-many relationship with products using the pivot table (order_product)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('price', 'quantity')  // Store price and quantity in the pivot table
                    ->withTimestamps();  // Optionally add timestamps to pivot table
    }

    // Define a custom relationship for the OrderDetail model (pivot table)
    public function OrderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id'); // Using 'order_id' in OrderDetail
    }

    public function getTotalPriceAttribute()
    {
        return $this->orderProducts->sum(function($orderProduct) {
            // dd( $orderProduct->price*$orderProduct->quantity);
            return $orderProduct->price * $orderProduct->quantity;
        });
    }

    public function getStatusClassAttribute()
    {
        if($this->status == 'Pending') {
            return 'bg-yellow-100 text-yellow-800';
        } elseif($this->status == 'Processing') {
            return 'bg-blue-100 text-blue-800';
        } elseif($this->status == 'Completed') {
            return 'bg-green-100 text-green-800';
        } elseif($this->status == 'Cancelled') {
            return 'bg-red-100 text-red-800';
        }
    }

    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'store_id');
    }
}
