<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'store_id', 'category_id', 'name', 'description', 'price', 'main_image'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

}
