<?php

namespace App\Repository\V1\Eloquent;

use App\Http\Resources\V1\ProductResource;
use App\Models\Category;
use App\Repository\V1\ProductRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function getProductList(array $filter_data): AnonymousResourceCollection
    {

        $products = $this->model->with('categories');

        if(isset($filter_data['search_product_name'])){
            $products->where('name', 'like', '%'.$filter_data['search_product_name'].'%');
        }

        if(isset($filter_data['category_id'])){
            $products->whereHas('categories', function($q) use ($filter_data){
                return $q->whereId($filter_data['category_id']);
            });
        }

        if(isset($filter_data['search_category_name'])){
            $products->whereHas('categories', function($q) use ($filter_data){
                return $q->where('name', 'like', '%'.$filter_data['search_category_name'].'%');
            });
        }

        if(isset($filter_data['search_price_from'])){
            $products->where('price', '>=', $filter_data['search_price_from']);
        }

        if(isset($filter_data['search_price_to'])){
            $products->where('price', '<=', $filter_data['search_price_to']);
        }

        if(isset($filter_data['show_published'])){
            $products->where('is_published', $filter_data['show_published']);
        }

        if(isset($filter_data['show_deleted'])){
            $products->withTrashed();
        }

        return ProductResource::collection($products->paginate($filter_data['count'] ?? 15));
    }

    /**
     * @inheritDoc
     */
    public function getProductById($id): ProductResource{
        return new ProductResource(Product::with('categories')->findOrFail($id));
    }

    /**
     * @inheritDoc
     */
    public function createProduct(array $data): ProductResource {
        DB::beginTransaction();
            $product = new Product();
            $product->name = $data['name'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->is_published = $data['is_published'] ?? false;
            $product->published_at = $data['is_published'] ? now() : null;
            $product->image = $data['image'] ?? null;

            $product->save();

            $product->categories()->saveMany($data['categories']);
        DB::commit();

        return new ProductResource($product);
    }

    /**
     * @inheritDoc
     */
    public function updateProduct($product_id, array $data): ProductResource {
        DB::beginTransaction();
            $data['published_at'] = $data['is_published'] ? now() : null;

            $updated_product = $this->find($product_id);

            $updated_product->fill($data);
            $updated_product->categories()->sync($data['categories']);

            $updated_product->save();
        DB::commit();

        return new ProductResource($updated_product);
    }

}
