<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\{OrderValidation,orderTrait};
use App\Models\{User,Product};

class Order extends Component
{
    use OrderValidation,orderTrait; // ✅ Import the trait here
    public $editMode = false;
    public $customers = [];
    public $selectedCustomer = null;
    public $searchCustomer = '';
    public $showCustomerDropdown = false;
    // ! Modal properties
    public $addEditOrderModal = false;
    public $viewOrderModal = false;
    // !Product properties
    public $products = [];
    public $selectedProduct = null;
    public $showProductDropdown = false;
    public $searchProduct = [];
    //! Order listing
    public $orders = [];
    //! order data
    public $viewed_order;

    //! loading state varaibles

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
    public function mount(){
        // $this->orders = $this->getOrders();
        // dd($this->orders);
    }
    // public function toggleModal($modelName,$data = null)
    // {
    //     if($modelName == 'addEditOrderModal'){
    //         $this->addEditOrderModal = !$this->addEditOrderModal;
    //     }elseif($modelName == 'viewOrderModal'){
    //         $this->view_btn_loading = ['active' => true, 'id' => $data];
    //         $this->viewOrderModal = !$this->viewOrderModal;
    //         $response = $this->getOrder($data);
    //         if($response['status'] == 'success'){
    //             $this->viewed_order = $this->getOrder($data)['data'];
    //             // dd($this->order->toArray());
    //         }else{
    //             session()->flash('status', $response['status']);
    //             session()->flash('message', $response['message']);
    //         }
    //         $this->view_btn_loading = ['active' => false, 'id' => null];
    //     }
    // }

    public function toggleModal($modelName, $data = null)
    {
        if ($modelName == 'addEditOrderModal') {
            $this->addEditOrderModal = !$this->addEditOrderModal;
        } elseif ($modelName == 'viewOrderModal') {
            // Set loading state when the modal is opened and button is clicked
            // Toggle modal visibility
            $this->viewOrderModal = !$this->viewOrderModal;

            // Fetch the order data
            $response = $this->getOrder($data);

            // Handle the response
            if ($response['status'] == 'success') {
                $this->viewed_order = $response['data'];
            } else {
                session()->flash('status', $response['status']);
                session()->flash('message', $response['message']);
            }
        }
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
        // dd($this->data);
        $order = $this->createOrder($this->data); // ✅ Call the method from the trait
        // Save order logic...
        session()->flash('status', $order['status']);
        session()->flash('message', $order['message']);
        $this->reset();
        // $this->orders = $this->getOrders();
    }


    public function closeModal($modelName='addEditOrderModal')
    {
        $this->reset();

        if ($modelName == 'addEditOrderModal') {
            $this->addEditOrderModal = false;
        } elseif ($modelName == 'viewOrderModal') {
            // Set loading state when the modal is opened and button is clicked
            // Toggle modal visibility
            $this->viewOrderModal = false;

        }
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
        if($this->products->count() <= 0)
            $this->data['order'][$index]['product_id'] = null;
        $this->showProductDropdown = 'productDropDownId'.$index;
    }

    public function closeDropdown()
    {
        $this->customers = [];
    }

    public function render()
    {
        $this->orders = $this->getOrders();
        return view('livewire.order');
    }
}
