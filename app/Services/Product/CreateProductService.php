<?php

namespace App\Services\Product;

use App\Contracts\ProductRepositoryInterface;

class CreateProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $product_repository;

    public function __construct(ProductRepositoryInterface $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function execute(array $attributes)
    {
        return $this->product_repository->create($attributes);
    }
}
