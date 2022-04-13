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

//        'count'
//        'search_product_name'
//        'category_id'
//        'search_category_name'
//        'search_price_from'
//        'search_price_to'
//        'show_published'
//        'show_deleted'
        $products = Product::with('categories');


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
    public function createProduct(array $data): ProductResource|bool {
        try {
            DB::beginTransaction();
                $product = new Product();
                $product->name = $data['name'];
                $product->description = $data['description'];
                $product->price = $data['price'];
                $product->is_published = $data['is_published'] ?? false;
                $product->published_at = $data['is_published'] ? now() : null;
                $product->image = $data['image'] ?? null;

                $product->save();

                $categories = Category::findOrFail($data['categories']);
                if(count($categories) !== count($data['categories'])){
                    return false;
                }

                $product->categories()->saveMany($categories);
            DB::commit();

            return new ProductResource($product);
        }
        catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function updateProduct($product_id, array $data): ProductResource|bool {
        try {
            DB::beginTransaction();
            $categories_ids = $data['categories'];
            unset($data['categories']);

            $data['published_at'] = $data['is_published'] ? now() : null;

            $update_product = Product::whereId($product_id)->update($data);
            $updated_product = Product::findOrFail($product_id);

            $categories = Category::findOrFail($categories_ids);

            if(count($categories) !== count($categories_ids)){
                return false;
            }

            $updated_product->categories()->sync($categories);
            DB::commit();

            return new ProductResource($updated_product);
        }
        catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }

}
