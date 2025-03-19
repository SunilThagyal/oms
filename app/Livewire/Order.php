<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\OrderValidation;
use App\Models\{User,Product};

class Order extends Component
{
    use OrderValidation; // ✅ Import the trait here
    public $addEditOrderModal = false;
    public $editMode = false;
    public $customers = [];
    public $selectedCustomer = null;
    public $searchCustomer = '';
    public $showCustomerDropdown = false;
    // !Product properties
    public $products = [];
    public $selectedProduct = null;
    public $showProductDropdown = false;
    public $searchProduct = [];

    public $data = [
        'customer' => [
            'name' => '',
            'email' => '',
            'phone' => '',
            'user_id' => 'null',
        ],
        'order' => [
            ['name' => '', 'quantity' => 1, 'price' => 0.00, 'product_id' => null],
        ],
        'status' => 'Pending',
        'date' => '',
    ];

    public function addEditOrder()
    {
        $this->addEditOrderModal = !$this->addEditOrderModal;
    }

    public function updated($propertyName)
    {
        if($propertyName == 'searchCustomer'){
            $this->updatedSearchCustomer($this->searchCustomer);
        }
        $this->validate();
    }

    public function addProduct()
    {
        $this->data['order'][] = ['name' => '', 'quantity' => '', 'price' => ''];
    }

    public function removeProduct($index)
    {
        unset($this->data['order'][$index]);
        $this->data['order'] = array_values($this->data['order']); // Reindex array
    }

    public function saveOrder()
    {
        $this->validate();
        DD( $this->data);
        // Save order logic...
        session()->flash('message', 'Order saved successfully.');

        $this->reset();
    }


    public function closeModal()
    {
        $this->reset();
    }

    public function selectCustomer($customerId)
    {
        // Logic to select the customer
        $this->selectedCustomer = User::find($customerId);
        $this->data['customer']['name'] = $this->selectedCustomer->name; // Update the input with the selected customer's name
        $this->data['customer']['email'] = $this->selectedCustomer->email;
        $this->data['customer']['user_id'] = $this->selectedCustomer->id;
        $this->showCustomerDropdown = false; // Hide the dropdown
    }

    public function updatedSearchCustomer($value)
    {
        if (strlen($value) > 1) {
            $this->data['customer']['name'] = null; // Update the input with the selected customer's name
            $this->data['customer']['email'] = null;
            $this->data['customer']['user_id'] = null;
            $this->data['customer']['name'] = $value;
            $this->customers = User::where('name', 'like', '%' . $value . '%')
                                       ->orWhere('email', 'like', '%' . $value . '%')
                                       ->get();
            $this->showCustomerDropdown = true; // Show the dropdown when there are results
        } else {
            $this->customers = [];
            $this->showCustomerDropdown = false; // Hide the dropdown if the search query is too short
        }
    }


    public function selectProduct($productId,$index)
    {
        // Logic to select the customer
        $this->selectedProduct = Product::find($productId);
        $this->searchProduct[$index] = $this->selectedProduct->name;
        $this->data['order'][$index]['name'] = $this->selectedProduct->name;
        $this->data['order'][$index]['price'] = $this->selectedProduct->price;
        $this->data['order'][$index]['product_id'] = $this->selectedProduct->id;
        $this->showProductDropdown = false; // Hide the dropdown
    }


    public function updatedSearchProduct($value, $index)
    {
        $value = trim($value); // Remove unnecessary spaces
        $this->data['order'][$index]['name'] = $value;
        if (strlen($value) < 1) {
            $this->products = [];
            $this->showProductDropdown = false;
            return;
        }
        $this->products = Product::where('name', 'like', "%{$value}%")->limit(10)->get();
        $this->showProductDropdown = 'productDropDownId'.$index;
    }

    public function closeDropdown()
    {
        $this->customers = [];
    }


    public function render()
    {
        return view('livewire.order');
    }
}
