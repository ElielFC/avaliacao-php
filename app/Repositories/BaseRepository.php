<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Contracts\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
     protected $model;

    /**
     * Construtor repositório base
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retorna todos os dados no repositório
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Retorna um determinado
     *
     * @param int $id
     * @return Model
     */
    public function getById(int $id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Armazene um recurso recém-criado no armazenamento.
     * @param  array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Atualize o recurso especificado no armazenamento.
     *
     * @param  int $id
     * @param  array $attributes
     * @return Model
     */
    public function update(int $id, array $attributes): Model
    {
        $model = $this->getById($id);

        $model->fill($attributes);

        $model->save();

        return $model;
    }

    /**
     * Remova o recurso especificado do armazenamento.
     *
     * @param  int $id
     * @return int
     */
    public function destroy(int $id): int
    {
        return $this->model->destroy($id);
    }
}
