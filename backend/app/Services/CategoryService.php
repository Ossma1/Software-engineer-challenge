<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAllParentCategories(): Collection
    {
        return $this->categoryRepository->getParents();
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function getOneCategory(int $categoryId): ?Category
    {
        return $this->categoryRepository->getOne($categoryId);
    }
    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
