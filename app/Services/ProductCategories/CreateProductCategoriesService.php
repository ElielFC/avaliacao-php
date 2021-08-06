<?php

namespace App\Services\ProductCategories;

use App\Contracts\ProductCategoriesRepositoryInterface;

class CreateProductCategoriesService
{
    /**
     * @var ProductCategoriesRepositoryInterface
     */
    private $product_categories_repository;

    public function __construct(ProductCategoriesRepositoryInterface $product_categories_repository)
    {
        $this->product_categories_repository = $product_categories_repository;
    }

    public function execute(array $attributes)
    {
        $product_categories = $this->product_categories_repository->create($attributes);

        return [
            'id' => $product_categories->id,
            'name' => $product_categories->name_category,
        ];
    }
}
