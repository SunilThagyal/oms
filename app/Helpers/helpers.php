<?php

use App\Models\Order;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('hash_id')) {
    function hash_id(int $id): string
    {
        return rtrim(strtr(base64_encode(pack('i', $id)), '=', '+/'), '+/');
    }
}

if (!function_exists('unhash_id')) {
    function unhash_id(string $hashed): int
    {
        $hex = unpack('i', base64_decode(strtr($hashed, '+/', '-_')));
        return $hex[1];
    }
}


if (!function_exists('orderCount')) {
    function orderCount($type = null)
    {
        $order = new Order();
        if ($type == 'all') {
            return $order->count();
        } elseif ($type == 'pending') {
            return  $order->where('status', 'Pending')->count();
        }
        elseif ($type == 'processing') {
            return  $order->where('status', 'processing')->count();
        } elseif ($type == 'completed') {
            return $order->where('status', 'completed')->count();
        } elseif ($type == 'cancelled') {
            return $order->where('status', 'cancelled')->count();
        } else {
            return $order->count();
        }
    }
}
