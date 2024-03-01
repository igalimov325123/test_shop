<?php

namespace App\Repository\V1;

use App\Http\Resources\V1\ProductResource;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ProductRepositoryInterface
{
    /**
     * Get product list with paginate
     *
     * @param array $filter_data
     * @return AnonymousResourceCollection
     */
    public function getProductList(array $filter_data): AnonymousResourceCollection;

    /**
     * Get product by id
     *
     * @param int $product_id
     * @return ProductResource
     */
    public function getProductById(int $product_id): ProductResource;

    /**
     * Create product from valid data
     *
     * @param array $data
     * @return ProductResource
     */
    public function createProduct(array $data): ProductResource;

    /**
     *
     * Update product from valid data
     *
     * @param int $product_id
     * @param array $data
     * @return ProductResource
     */
    public function updateProduct(int $product_id, array $data): ProductResource;

    /**
     * Soft delete product by ID
     *
     * @param int $product_id
     * @return bool
     */public function delete(int $product_id): bool;

}
