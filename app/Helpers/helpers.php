<?php
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
