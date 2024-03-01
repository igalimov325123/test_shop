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

    /**
     * @inheritDoc
     */
    public function find($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $item = $this->model->find($id);

        if(empty($item)){
            throw new \Exception('Запись не найдена', 404);
        }

        return $item->delete();
    }

}
