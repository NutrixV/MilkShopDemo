<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Тест створення категорії
     *
     * @return void
     */
    public function test_create_category(): void
    {
        $category = Category::create([
            'name' => 'Тестова категорія',
            'description' => 'Опис тестової категорії'
        ]);
        
        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('Тестова категорія', $category->name);
        $this->assertDatabaseHas('categories', [
            'name' => 'Тестова категорія'
        ]);
    }
    
    /**
     * Тест створення продукту
     *
     * @return void
     */
    public function test_create_product(): void
    {
        $category = Category::create([
            'name' => 'Тестова категорія',
            'description' => 'Опис тестової категорії'
        ]);
        
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Тестовий продукт',
            'description' => 'Опис тестового продукту',
            'price' => 99.99,
            'in_stock' => true,
            'fat_content' => '3.2%',
            'volume' => 1000,
            'unit' => 'ml',
            'expiration_date' => '2025-12-31',
            'manufacturer' => 'Тест',
            'storage_temp' => '0-5°C',
            'is_organic' => true,
        ]);
        
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Тестовий продукт', $product->name);
        $this->assertEquals($category->id, $product->category_id);
        $this->assertDatabaseHas('products', [
            'name' => 'Тестовий продукт'
        ]);
    }
    
    /**
     * Тест зв'язку між категорією і продуктами
     *
     * @return void
     */
    public function test_category_has_products(): void
    {
        $category = Category::create([
            'name' => 'Тестова категорія',
            'description' => 'Опис тестової категорії'
        ]);
        
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Тестовий продукт',
            'description' => 'Опис тестового продукту',
            'price' => 99.99,
            'in_stock' => true,
            'fat_content' => '3.2%',
            'volume' => 1000,
            'unit' => 'ml',
            'expiration_date' => '2025-12-31',
            'manufacturer' => 'Тест',
            'storage_temp' => '0-5°C',
            'is_organic' => true,
        ]);
        
        $this->assertTrue($category->products()->exists());
        $this->assertEquals(1, $category->products()->count());
        $this->assertEquals('Тестовий продукт', $category->products()->first()->name);
    }
} 