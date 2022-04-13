<?php
namespace App\Repository\V1;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;


}

