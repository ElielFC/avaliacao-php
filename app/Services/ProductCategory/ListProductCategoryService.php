<?php

namespace App\Services\ProductCategory;

use App\Contracts\ProductCategoryRepositoryInterface;

class ListProductCategoryService
{
    /**
     * @var ProductCategoryRepositoryInterface
     */
    private $product_categories_repository;

    public function __construct(ProductCategoryRepositoryInterface $product_categories_repository)
    {
        $this->product_categories_repository = $product_categories_repository;
    }

    public function execute()
    {
        $product_categories = $this->product_categories_repository->all();

        return $product_categories->map( function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name_category,
            ];
        });
    }
}
