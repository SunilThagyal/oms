<?php
namespace App\Traits;
use App\Models\{Order,User,OrderProduct, Store};
use App\Traits\{customerTrait, productTrait, ResponseHandlerTrait};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
trait orderTrait
{
    use customerTrait,productTrait,ResponseHandlerTrait;

    protected function getOrders($filters =null)
    {
        $query = Order::with(['customer', 'orderProducts.product'])
            ->where('store_id', auth()->user()->store->id)
            ->latest();

        if ($filters) {
            $this->applyFilters($query, $filters);
        }

        return $query->paginate(10);
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

    protected function deleteOrder($orderId): array
    {
        DB::beginTransaction();
        try {
            $order = Order::find(unhash_id($orderId));
            if (!$order) {
                return $this->notFoundResponse('Order');
            }
            $order->delete();
            DB::commit();
            return $this->successResponse(null, 'Order deleted successfully.');
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
    private function applyFilters($query, array $filters)
    {
        // Apply search filter if it exists and is not empty
        if (!empty($filters['searchOrder'] ?? null)) {
            $this->applySearchConditions($query, trim($filters['searchOrder']));
        }

        // Apply status filter if it exists and is not empty
        if (!empty($filters['status'] ?? null)) {
            $query->where('status', $filters['status']);
        }

        // Apply date range filter if both dates exist
        if (!empty($filters['date_range']['from'] ?? null) &&
            !empty($filters['date_range']['to'] ?? null)) {
            $query->whereBetween('created_at', [
                Carbon::parse($filters['date_range']['from'])->startOfDay(),
                Carbon::parse($filters['date_range']['to'])->endOfDay()
            ]);
        }

        return $query;
    }

    private function applySearchConditions($query, string $searchTerm)
    {
        if (str_contains(strtoupper($searchTerm), 'ORD-')) {
            $orderId = $this->normalizeOrderId($searchTerm);
            $query->where('id', 'like', "%{$orderId}%");
            return;
        }

        $query->where(function ($query) use ($searchTerm) {
            $query->where('id', 'like', "%{$searchTerm}%")
                ->orWhereHas('customer', fn ($q) => $q->where('name', 'like', "%{$searchTerm}%"))
                ->orWhereHas('orderProducts.product', fn ($q) => $q->where('name', 'like', "%{$searchTerm}%"));
        });
    }

    private function normalizeOrderId(string $orderId): string
    {
        return unhash_id(str_replace(['ORD-', ' '], '', $orderId));
    }

}

