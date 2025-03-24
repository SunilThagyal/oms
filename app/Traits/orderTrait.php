<?php
namespace App\Traits;
use App\Models\{Order,User,OrderProduct};
use App\Traits\{customerTrait, productTrait, ResponseHandlerTrait};
use Illuminate\Support\Facades\DB;
trait orderTrait
{
    use customerTrait,productTrait,ResponseHandlerTrait;

    protected function getOrders(){
        $store_id = auth()->user()->store->id;
        $orders = Order::where('store_id', $store_id)
        // ->with('customer','orderProducts.product')
        ->get();
        // dd($orders);
        return $orders;
    }
    protected function createOrder(array $data): array
    {
        DB::beginTransaction();

        try {
            $customer = $this->resolveCustomer($data['customer']);
            $order = $this->createNewOrder($customer->id, $data);
            $this->attachOrderItems($order->id, $data['order']);

            DB::commit();

            return $this->successResponse($order, 'Order saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e);
        }
    }





    /**** private functions ****/

    private function resolveCustomer(array $customerData)
    {
        return isset($customerData['user_id'])
            ? User::find($customerData['user_id'])
            : $this->createCustomer($customerData);
    }

    private function createNewOrder(int $customerId, array $data): Order
    {
        return Order::create([
            'customer_id' => $customerId,
            'store_id' => auth()->user()->store->id,
            'status' => $data['status'],
            'date' => $data['date'],
        ]);
    }

    private function attachOrderItems(int $orderId, array $orderItems): void
    {
        foreach ($orderItems as $item) {
            $productId = $item['product_id'] ?? $this->createProduct($item)->id;
            OrderProduct::create([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    }

}

