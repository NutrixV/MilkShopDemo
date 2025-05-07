<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Клас тестів для перевірки сторінки деталей продукту
 *
 * @category Tests
 * @package  MilkShopV2
 */
class ProductDetailsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест перегляду сторінки деталей продукту
     */
    public function test_product_details_page_displays_correctly()
    {
        // Створюємо категорію
        $category = Category::factory()->create([
            'name' => 'Категорія для тесту'
        ]);
        
        // Створюємо продукт
        $product = Product::factory()->create([
            'name' => 'Тестовий продукт з деталями',
            'description' => 'Детальний опис тестового продукту',
            'price' => 42.99,
            'category_id' => $category->id,
            'in_stock' => true,
            'manufacturer' => 'Тестовий виробник',
            'fat_content' => '3.2%'
        ]);
        
        // Відвідуємо сторінку продукту
        $response = $this->get('/product/' . $product->id);
        
        // Перевіряємо статус і вміст
        $response->assertStatus(200);
        $response->assertSee('Тестовий продукт з деталями');
        $response->assertSee('Детальний опис тестового продукту');
        $response->assertSee('42.99');
        $response->assertSee('Тестовий виробник');
        $response->assertSee('3.2%');
        $response->assertSee('Категорія для тесту');
    }
    
    /**
     * Тест сторінки неіснуючого продукту
     */
    public function test_nonexistent_product_returns_404()
    {
        // Спроба доступу до неіснуючого продукту
        $response = $this->get('/product/999999');
        
        // Перевіряємо, що отримали помилку 404
        $response->assertStatus(404);
    }
} 