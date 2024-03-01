<?php

namespace App\Repository\V1;

use App\Http\Resources\V1\CategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface CategoryRepositoryInterface
{
    /**
     * Get category list
     *
     * @return AnonymousResourceCollection
     */
    public function getCategoryList(): AnonymousResourceCollection;

    /**
     * Create category
     *
     * @param array $category_data
     * @return CategoryResource
     */
    public function createCategory(array $category_data): CategoryResource;
}
