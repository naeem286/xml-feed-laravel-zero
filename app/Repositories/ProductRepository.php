<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\MongoProduct;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function insert(array $data)
    {
        if (config( 'database.default' ) == 'mongodb') {
            $product = new MongoProduct;
        } else {
            $product = new Product;
        }
        $product->product_data = $data;
        $product->save();
    }
}