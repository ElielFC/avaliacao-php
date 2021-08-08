<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Busca em produtos por filtros
     * @param array $attributes
     * @param int|null $limit
     * @return Collection
     */
    public function getByFilters(array $attributes = [], ?int $limit = 20): Collection;
}
