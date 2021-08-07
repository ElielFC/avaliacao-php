<?php

namespace App\Services\ProductCategory;

use App\Contracts\ProductCategoryRepositoryInterface;
use App\Exceptions\ProductCategoryWithProductsException;

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
        $product_category = $this->product_categories_repository->getById($id);

        $product_category->loadCount('products');

        if ($product_category->products_count > 0) {
            throw new ProductCategoryWithProductsException('Não é possível excluir uma categoria de produto que já esteja associada a Produtos', 403);
        }

        return $this->product_categories_repository->destroy($id);
    }
}
