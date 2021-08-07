<?php

namespace App\Services\ProductCategory;

use App\Contracts\ProductCategoryRepositoryInterface;

class DeleteProductCategoryService
{
    /**
     * @var ProductCategoryRepositoryInterface
     */
    private $product_categories_repository;

    public function __construct(ProductCategoryRepositoryInterface $product_categories_repository)
    {
        $this->product_categories_repository = $product_categories_repository;
    }

    public function execute(int $id)
    {
        return $this->product_categories_repository->destroy($id);
    }
}
