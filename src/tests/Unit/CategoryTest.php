<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Клас тестів для перевірки категорій
 *
 * @category Tests
 * @package  MilkShopV2
 */
class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест створення категорії
     */
    public function test_can_create_category()
    {
        $categoryData = [
            'name' => 'Йогурти',
            'description' => 'Різноманітні йогурти',
            'image_path' => 'yogurt.jpg'
        ];
        
        $category = Category::create($categoryData);
        
        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('Йогурти', $category->name);
        $this->assertEquals('Різноманітні йогурти', $category->description);
    }
    
    /**
     * Тест відношення категорії до продуктів
     */
    public function test_category_has_many_products()
    {
        $category = Category::factory()->create();
        
        // Створюємо продукти для категорії
        $products = Product::factory()->count(3)->create([
            'category_id' => $category->id
        ]);
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->products);
        $this->assertCount(3, $category->products);
    }
    
    /**
     * Тест soft delete для категорії
     */
    public function test_category_soft_delete()
    {
        $category = Category::factory()->create();
        $categoryId = $category->id;
        
        $category->delete();
        
        $this->assertSoftDeleted('categories', ['id' => $categoryId]);
    }
}
