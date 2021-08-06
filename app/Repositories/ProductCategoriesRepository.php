<?php

namespace App\Repositories;

use App\Contracts\ProductCategoriesRepositoryInterface;
use App\Models\ProductCategories;

class ProductCategoriesRepository extends BaseRepository implements ProductCategoriesRepositoryInterface
{
    public function __construct(ProductCategories $model)
    {
        parent::__construct($model);
    }
}
