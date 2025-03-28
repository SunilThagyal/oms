<?php
namespace App\Traits;
use App\Models\{Order,User,OrderProduct, Store};
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

    protected function createOrder(array $data, $orderId = null): array
    {
        DB::beginTransaction();
        try {
            $orderId = $orderId ? unhash_id($orderId) : null;
            $customer = $this->resolveCustomer($data['customer']);
            $order = $this->createNewOrder($customer->id, $data, $orderId);
            $this->attachOrderItems($order->id, $data['order']);

            DB::commit();

            return $this->successResponse($order, 'Order saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e);
        }
    }

    protected function getOrder($orderId): array
    {
        $order = Order::with('store', 'customer.customerDetails', 'orderProducts.product')->find(unhash_id($orderId));
        return $order
            ? $this->successResponse($order, 'Order retrieved successfully.')
            : $this->notFoundResponse('Order');
    }





    /**** private functions ****/

    private function resolveCustomer(array $customerData)
    {
        return isset($customerData['user_id'])
            ? User::find($customerData['user_id'])
            : $this->createCustomer($customerData);
    }

    private function createNewOrder(int $customerId, array $data, $orderId): Order
    {
        return Order::updateOrCreate(
            ['id' => $orderId],
            [
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
            $orderProductId = isset($item['order_product_id']) ?  unhash_id($item['order_product_id']) : null;
            OrderProduct::updateOrCreate(['id' => $orderProductId],[
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    }

}

