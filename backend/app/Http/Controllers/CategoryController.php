<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): ResourceCollection
    {
        $categories = $this->categoryService->getAllParentCategories();

        return CategoryResource::collection($categories);
    }

    public function store(CategoryRequest $request): CategoryResource
    {
        $data = $request->only([
            'name',
            'parent_id',
        ]);

        $category = $this->categoryService->createCategory($data);

        return new CategoryResource($category);
    }

    public function destroy(Category $category): CategoryResource
    {
        $deleted = $this->categoryService->forceDeleteCategory($category);

        return new CategoryResource($deleted);
    }
}
