<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Category;
use App\Repository\V1\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->categoryRepository->getCategoryList();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     */
    public function store(CategoryStoreRequest $request)
    {
        try {
            $category_data = $request->validated();

            return $this->categoryRepository->createCategory($category_data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try{
            $this->categoryRepository->delete($id);

            return response()->json([
                'message' => 'Категория удалена'
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'massage' => 'Ошибка при удалении'
            ], 400);
        }
    }
}
