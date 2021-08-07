<?php

namespace App\Services\ProductCategory;

use App\Contracts\ProductCategoryRepositoryInterface;

class ShowProductCategoryService
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
        $product_categories = $this->product_categories_repository->getById($id);

        return [
            'id' => $product_categories->id,
            'name' => $product_categories->name_category,
        ];
    }
}
