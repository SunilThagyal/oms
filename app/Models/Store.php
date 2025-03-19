<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'user_id',
        'main_image',
        'status',
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }



}
