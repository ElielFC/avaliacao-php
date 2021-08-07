<?php

namespace App\Services\Product;

use App\Contracts\ProductRepositoryInterface;

class UpdateProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $product_repository;

    public function __construct(ProductRepositoryInterface $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function execute(int $id, array $attributes)
    {
        return $this->product_repository->update($id, $attributes);
    }
}
