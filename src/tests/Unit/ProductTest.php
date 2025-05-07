<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Клас тестів для перевірки моделі Product
 *
 * @category Tests
 * @package  MilkShopV2
 */
class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест створення продукту
     *
     * @return void
     */
    public function testCanCreateProduct()
    {
        $category = Category::factory()->create();
        
        $productData = [
            'name' => 'Молоко тестове',
            'description' => 'Опис тестового молока',
            'price' => 25.50,
            'category_id' => $category->id
        ];
        
        $product = Product::create($productData);
        
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Молоко тестове', $product->name);
        $this->assertEquals(25.50, $product->price);
        $this->assertEquals($category->id, $product->category_id);
    }
    
    /**
     * Тест відношення продукту до категорії
     *
     * @return void
     */
    public function testProductBelongsToCategory()
    {
        $category = Category::factory()->create(['name' => 'Тестова категорія']);
        $product = Product::factory()->create(['category_id' => $category->id]);
        
        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals('Тестова категорія', $product->category->name);
    }
    
    /**
     * Тест soft delete для продукта
     *
     * @return void
     */
    public function testProductSoftDelete()
    {
        $product = Product::factory()->create();
        $productId = $product->id;
        
        $product->delete();
        
        $this->assertSoftDeleted('products', ['id' => $productId]);
    }
}
