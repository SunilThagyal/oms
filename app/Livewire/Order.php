<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\OrderValidation;
use App\Models\User;

class Order extends Component
{
    use OrderValidation; // ✅ Import the trait here
    public $addEditOrderModal = false;
    public $editMode = false;
    public $customers = [];
    public $selectedCustomer = null;
    public $searchCustomer = '';
    public $showDropdown = false;

    public $data = [
        'customer' => [
            'name' => '',
            'email' => '',
            'phone' => '',
        ],
        'order' => [
            ['name' => '', 'quantity' => 1, 'price' => 0.00]
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
        $this->validateOnly($propertyName);
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
        $this->showDropdown = false; // Hide the dropdown
    }

    public function updatedSearchCustomer($value)
    {
        if (strlen($value) > 1) {
            $this->data['customer']['name'] = $value;
            $this->customers = User::where('name', 'like', '%' . $value . '%')
                                       ->orWhere('email', 'like', '%' . $value . '%')
                                       ->get();
            $this->showDropdown = true; // Show the dropdown when there are results
        } else {
            $this->customers = [];
            $this->showDropdown = false; // Hide the dropdown if the search query is too short
        }
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
