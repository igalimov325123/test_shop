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
     * @return \Illuminate\Http\JsonResponse|ProductResource
     */
    public function store(CategoryStoreRequest $request)
    {
        $category_data = $request->validated();

        $created_category =  $this->categoryRepository->createCategory($category_data);

        if(!$created_category){
            return response()->json([
                'message' => 'При создании категории возникла ошибка'
            ], 400);
        }

        return $created_category;
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
            $category = Category::find($id);
            if(empty($category)){
                return response()->json([
                    'error'=> 'Категория не существует в системе'
                ], 400);
            }
            $this->categoryRepository->delete($id);

            return response()->json([
                'status'=> true
            ], 200);

        } catch (\Exception $e){
            return response()->json([
                'error'=> 'Данная категория привязана к товару'
            ], 400);
        }
    }
}
