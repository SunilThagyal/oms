<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $fillable = [
        'user_id', 'name', 'address', 'country', 'city', 'state', 'pincode', 'main_image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function images()
    {
        return $this->hasMany(StoreImage::class);
    }

}
