<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    protected $productService;
    protected $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = app(ProductService::class);
        $this->categoryService = app(CategoryService::class);

        $this->categoryService->createCategory(['name' => 'Electronics']);
    }

    /** @test */
    public function test_invalid_price_format()
    {
        $category = Category::first();

        $data = [
            'name' => 'Test Product',
            'description' => 'A sample product for testing.',
            'price' => 'invalidPrice',
            'category_ids' => [$category->id],
        ];

        $this->expectException(ValidationException::class); // Ensure validation exception is thrown
        $this->productService->createProduct($data);

        // Test with a negative price
        $data['price'] = -49.99;

        $this->expectException(ValidationException::class); // Ensure validation exception is thrown
        $this->productService->createProduct($data);
        $product->delete();
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);
    }

    /** @test */
    public function test_create_product_with_category()
    {
        $category = Category::first();

        $data = [
            'name' => 'Smartphone',
            'description' => 'Latest model with high-end features.',
            'price' => 799.99,
            'category_ids' => [$category->id],
        ];

        $product = $this->productService->createProduct($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Smartphone', $product->name);
        $this->assertEquals(799.99, $product->price);
        $this->assertTrue($product->categories->contains($category));
    }

    /** @test */
    public function test_create_product_without_category()
    {
        $data = [
            'name' => 'Laptop',
            'description' => 'High-performance laptop for professionals.',
            'price' => 1299.99
        ];

        $product = $this->productService->createProduct($data);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Laptop', $product->name);
        $this->assertEquals(1299.99, $product->price);
    }

    /** @test */
    public function test_ignore_non_existing_category_ids()
    {
        $category = Category::first();
        $nonExistentCategoryId = $category->id + 1;

        $data = [
            'name' => 'Tablet',
            'description' => 'Lightweight and portable tablet.',
            'price' => 499.99,
            'category_ids' => [$nonExistentCategoryId],
        ];

        $product = $this->productService->createProduct($data);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Tablet', $product->name);
        $this->assertEquals(499.99, $product->price);
        $this->assertFalse($product->categories->contains($category));
    }

    /** @test */
    public function test_create_product_with_multiple_categories()
    {
        $this->categoryService->createCategory(['name' => 'Accessories']);
        $categoryIds = Category::pluck('id')->toArray();

        $data = [
            'name' => 'Smartwatch',
            'description' => 'Smartwatch with health tracking features.',
            'price' => 199.99,
            'category_ids' => $categoryIds,
        ];

        $product = $this->productService->createProduct($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertCount(2, $product->categories);
    }
}
