<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    protected $fillable = [
        'user_id', 'address', 'country', 'city', 'state', 'gender', 'phone', 'profile_picture'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
