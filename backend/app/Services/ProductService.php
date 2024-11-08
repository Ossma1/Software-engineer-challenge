<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    protected $productRepo;
    protected $categoryRepo;

    public function __construct(ProductRepository $productRepo, CategoryRepository $categoryRepo)
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function getOneProduct(int $productId): ?Product
    {
        return $this->productRepo->getOne($productId);
    }

    public function getPaginatedProducts(array $filters, string $sortBy): LengthAwarePaginator
    {
        if (!empty($filters['category_id'])) {
            $categoryIds = $this->categoryRepo->getOneWithDescendants($filters['category_id']);

            if (!empty($categoryIds)) {
                $filters['category_id'] = $categoryIds;
            }
        }

        return $this->productRepo->getPaginated($filters, $sortBy);
    }

    public function createProduct(array $data): Product
    {
        $validator = Validator::make($data, [
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $this->productRepo->create($data);
    }

    public function deleteProduct(Model $product): bool
    {
        return $this->productRepo->delete($product);
    }

    public function saveImageFromURL(string $URL): string
    {
        if (filter_var($URL, FILTER_VALIDATE_URL) === false) {
            throw new \Exception('Invalid URL provided');
        }

        $imageContent = @file_get_contents($URL);

        if ($imageContent === false) {
            throw new \Exception('Unable to download image from URL');
        }

        $filename = basename($URL);

        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
            throw new \Exception('Invalid image file type');
        }

        $newPath = 'products/' . uniqid() . '_' . $filename;

        Storage::disk('public')->put($newPath, $imageContent);

        return 'storage/' . $newPath;
    }
}
