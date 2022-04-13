<?php

namespace App\Repository\V1\Eloquent;

use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use App\Repository\V1\CategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Product;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function getCategoryList(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * @inheritDoc
     */
    public function createCategory(array $category_data): CategoryResource|bool
    {
        $category = Category::create([
            'name' => $category_data['name'],
        ]);

        return new CategoryResource($category);
    }
}
