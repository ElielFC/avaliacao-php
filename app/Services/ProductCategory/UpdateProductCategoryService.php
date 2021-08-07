<?php

namespace App\Services\ProductCategory;

use App\Contracts\ProductCategoryRepositoryInterface;

class UpdateProductCategoryService
{
    /**
     * @var ProductCategoryRepositoryInterface
     */
    private $product_categories_repository;

    public function __construct(ProductCategoryRepositoryInterface $product_categories_repository)
    {
        $this->product_categories_repository = $product_categories_repository;
    }

    public function execute(int $id, array $attributes)
    {
        $product_categories = $this->product_categories_repository->update($id, $attributes);

        return [
            'id' => $product_categories->id,
            'name' => $product_categories->name_category,
        ];
    }
}
