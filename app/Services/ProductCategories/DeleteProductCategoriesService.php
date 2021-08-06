<?php

namespace App\Services\ProductCategories;

use App\Contracts\ProductCategoriesRepositoryInterface;

class DeleteProductCategoriesService
{
    /**
     * @var ProductCategoriesRepositoryInterface
     */
    private $product_categories_repository;

    public function __construct(ProductCategoriesRepositoryInterface $product_categories_repository)
    {
        $this->product_categories_repository = $product_categories_repository;
    }

    public function execute(int $id)
    {
        return $this->product_categories_repository->destroy($id);
    }
}
