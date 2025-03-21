<?php

namespace App\Traits;

trait OrderValidation
{
    public function rules()
    {
        $rules = [
            'data.customer.name' => 'required',
            'data.customer.email' => ['required', 'email'],
            'data.customer.phone' => 'required',
            'data.status' => 'required',
            'data.date' => 'required|date',
            'data.order.*.name' => 'required',
            'data.order.*.quantity' => 'required|integer|min:1',
            'data.order.*.price' => 'required|numeric|min:0.01',
        ];

        // Add unique email rule only if user_id is not set (new customer case)
        if (!empty($this->data['customer']['user_id'])) {
            $rules['data.customer.email'][] = 'unique:users,email,' . $this->data['customer']['user_id'];
        } else {
            $rules['data.customer.email'][] = 'unique:users,email';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'data.customer.name.required' => 'Customer name is required.',
            'data.customer.email.required' => 'Customer email is required.',
            'data.customer.email.email' => 'Enter a valid email address.',
            'data.customer.email.unique' => 'This email is already in use.',
            'data.customer.phone.required' => 'Customer phone number is required.',
            'data.status.required' => 'Order status is required.',
            'data.date.required' => 'Order date is required.',
            'data.date.date' => 'Enter a valid date format.',

            // Order item validation messages
            'data.order.*.name.required' => 'Product name is required.',
            'data.order.*.quantity.required' => 'Product quantity is required.',
            'data.order.*.quantity.integer' => 'Quantity must be a whole number.',
            'data.order.*.quantity.min' => 'Quantity must be at least 1.',
            'data.order.*.price.required' => 'Product price is required.',
            'data.order.*.price.numeric' => 'Price must be a valid number.',
            'data.order.*.price.min' => 'Price must be at least 0.01.',
        ];
    }
}
