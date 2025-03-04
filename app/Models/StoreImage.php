<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreImage extends Model
{
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
