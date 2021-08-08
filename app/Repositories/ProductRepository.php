<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Busca em produtos por filtros
     * @param array $attributes
     * @param int|null $limit
     * @return Collection
     */
    public function getByFilters(array $attributes = [], ?int $limit = 20): Collection
    {
        return $this->model
            ->when(!empty($attributes['product_name']), function ($query) use ($attributes) {
                return $query->where('product_name', 'like', '%' . $attributes['product_name'] . '%');
            })
            ->when(!empty($attributes['product_category_id']), function ($query) use ($attributes) {
                return $query->whereHas('productCategory', function ($query) use ($attributes) {
                    return $query->where('id', $attributes['product_category_id']);
                });
            })
            ->when($limit, function ($query) use ($limit) {
                return $query->limit($limit);
            })
            ->get();
    }
}
