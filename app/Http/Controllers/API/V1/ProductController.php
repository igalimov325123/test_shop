<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Repository\V1\ProductRepositoryInterface;
use App\Services\ImageUploaderService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepository;
    private $imageUploaderService;

    public function __construct(ProductRepositoryInterface $productRepository, ImageUploaderService $imageUploaderService)
    {
        $this->productRepository = $productRepository;
        $this->imageUploaderService = $imageUploaderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProductIndexRequest $request)
    {
        $filter_data = $request->validated();

        return $this->productRepository->getProductList($filter_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|ProductResource
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            $product_data = $request->validated();

            if($request->hasFile('image')){
                $product_data['image'] = $this->imageUploaderService->saveImageAndGetPath($request->file('image'));
            }

            return $this->productRepository->createProduct($product_data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return ProductResource
     */
    public function show(int $id)
    {
        return $this->productRepository->getProductById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|ProductResource
     */
    public function update(int $id, ProductUpdateRequest $request)
    {
        try {
            $product_data = $request->validated();

            if($request->hasFile('image')){
                $product_data['image'] = $this->imageUploaderService->saveImageAndGetPath($request->file('image'));
            }

            return $this->productRepository->updateProduct($id, $product_data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->productRepository->delete($id);

            return response()->json([
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при удалении'
            ], $e->getCode());
        }
    }
}
