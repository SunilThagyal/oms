<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreImage extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'image_path'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
