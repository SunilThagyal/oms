<?php
namespace App\Traits;
use App\Models\Product;

trait productTrait{

    protected function createProduct($data){
        $authUser = auth()->user(); //store
        $product = Product::create([
            'store_id' => $authUser->id,
            'category_id' => $data['category_id'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'main_image' => $data['main_image'] ?? null,
            'price' => $data['price'],
            'quantity' => $data['quantity'] ?? 0,
        ]);
        return $product;
    }
}
