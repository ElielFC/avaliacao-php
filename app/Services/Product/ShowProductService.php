<?php

namespace App\Services\Product;

use App\Contracts\ProductRepositoryInterface;

class ShowProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $product_repository;

    public function __construct(ProductRepositoryInterface $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function execute(int $id)
    {
        $product = $this->product_repository->getById($id);

        return [
            'id' => $product->id,
            'product_name' => $product->product_name,
            'product_category_name' => $product->productCategory->name_category,
            'registration_date' => $product->registration_date,
            'product_value' => $product->product_value,
        ];
    }
}
