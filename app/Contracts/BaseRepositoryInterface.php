<?php

namespace App\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Retorna todos os dados no repositório
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Retorna um determinado
     *
     * @param int $id
     * @return Model
     */
    public function getById(int $id): ?Model;

    /**
     * Armazene um recurso recém-criado no armazenamento.
     * @param  array $request
     * @return Model
     */
    public function create(array $request): Model;

    /**
     * Atualize o recurso especificado no armazenamento.
     *
     * @param  int $id
     * @param  array $attributes
     * @return Model
     */
    public function update(int $id, array $attributes): Model;

    /**
     * Remova o recurso especificado do armazenamento.
     *
     * @param  int $id
     * @return int
     */
    public function destroy(int $id): int;

    /**
     * Adiciona escopos ao modelo
     *
     * @param  array $scopes
     * @return $this
     */
    public function addLocalScopes(array $scopes);
}
