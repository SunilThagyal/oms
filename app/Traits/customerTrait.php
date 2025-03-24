<?php

namespace App\Traits;

use App\Models\User;

trait customerTrait
{
    protected function createCustomer($data){
        if (empty($data['email'])) {
            $data['email'] = 'customer' . uniqid() . '@example.com';
        }
        if (empty($data['password'])) {
            $data['password'] = bcrypt('###123');
        }
        $customer_role = config('user.role.customer');
        $customer = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' =>  bcrypt('pass@admin'),
        ]);
        $customer->assignRole($customer_role);
        return $customer;
    }
}
