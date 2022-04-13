<?php


namespace App\Repository\V1\Eloquent;

use App\Repository\V1\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }

}
