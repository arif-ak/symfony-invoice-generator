<?php

namespace App\Service;

use App\Repository\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $productRepository)
    {}

    public function getProductData(): array
    {
        $products = $this->productRepository->findAll();
        $productList = [];

        foreach ($products as $product) {
            $productList[$product->getId()] = ['quantity' => $product->getQuantity(), 'price' => $product->getPrice()];
        }

        return [
            'productList' => $productList,
            'productIds' => array_keys($productList),
        ];
    }
}
