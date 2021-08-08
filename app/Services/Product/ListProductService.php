<?php

namespace App\Services\Product;

use App\Contracts\ProductRepositoryInterface;

class ListProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $product_repository;

    public function __construct(ProductRepositoryInterface $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function execute(array $attributes = [])
    {
        $products = $this->product_repository->getByFilters($attributes);

        $products->loadMissing('productCategory');

        return $products->map(function ($item) {
            return [
                'id' => $item->id,
                'product_name' => $item->product_name,
                'product_category_name' => $item->productCategory->name_category,
                'registration_date' => $item->registration_date,
                'product_value' => $item->product_value,
            ];
        });
    }
}
