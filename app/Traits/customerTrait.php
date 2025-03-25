<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

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

    protected function updateCustomerDetails($customer, $data)
    {
        // If there's a profile picture, store it and get the path
        $profilePicturePath = null;
        if (isset($data['profile_picture']) && $data['profile_picture']) {
            $profilePicturePath = $this->storeImage($data['profile_picture']);
        }

        // Update or create the customer details with the stored image path
        $customer->customerDetails()->updateOrCreate(
            ['user_id' => $customer->id],
            [
                'address' => $data['address'] ?? null,
                'country' => $data['country'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'gender' => $data['gender'] ?? null,
                'phone' => $data['phone'] ?? null,
                'profile_picture' => $profilePicturePath, // Store the image path in database
            ]
        );

        // You can still assign the role if needed
        // $customer->assignRole($customer_role);

        return $customer;
    }

    protected function storeImage($image)
    {
        // Generate a unique file name for the image
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Store the image in the 'public/profile_pictures' directory
        $path = $image->storeAs('profile_pictures/customers', $imageName);

        // Return the relative path to store in the database
        return $path;
    }

}
