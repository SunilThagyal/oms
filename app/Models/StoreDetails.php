<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreDetails extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'address',
        'country',
        'city',
        'state',
        'pincode',
        'other_images',
    ];

    protected $casts = [
        'other_images' => 'array', // Cast the 'other_images' JSON column to an array
    ];

    // Relationship with Store
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
