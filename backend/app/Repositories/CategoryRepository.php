<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    public function getParents(): Collection
    {
        $categories = Category::where('parent_category_id', null)->with('children')->get();

        return $categories;
    }

    public function getAll(): Collection
    {
        $categories = Category::all();

        return $categories;
    }

    public function getOne(int $categoryId): ?Category
    {
        $category = Category::with('children')->find($categoryId);

        return $category;
    }

    public function getOneWithDescendants(int $categoryId): array
    {
        $category = Category::with('children')->find($categoryId);

        return $this->collectDescendantIds($category, [$category->id]);
    }

    private function collectDescendantIds(Category $category, array $ids = []): array
    {
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            $ids = $this->collectDescendantIds($child, $ids);
        }

        return $ids;
    }

    public function create(array $attributes): Category
    {
        return DB::transaction(function () use ($attributes) {
            if (!empty(data_get($attributes, 'parent_category_id'))) {
                $parentCategory = Category::find(data_get($attributes, 'parent_category_id'));

                if (!$parentCategory) {
                    throw new \Exception('Invalid parent_category_id.');
                }
            }

            $category = Category::create([
                'name' => data_get($attributes, 'name'),
                'parent_category_id' => data_get($attributes, 'parent_category_id', null),
            ]);

            return $category;
        });
    }

    public function delete(Model $category): bool
    {
        return DB::transaction(function () use ($category) {
            $deleted = $category->delete();

            if (!$deleted) {
                throw new \Exception('Faild to delete this category.');
            }

            return $deleted;
        });
    }
}
