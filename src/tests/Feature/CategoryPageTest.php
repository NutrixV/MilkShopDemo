<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Клас тестів для перевірки сторінки категорії
 *
 * @category Tests
 * @package  MilkShopV2
 */
class CategoryPageTest extends TestCase
{
    use RefreshDatabase;

    /** @var Category */
    protected $category;
    
    /** @var Product[] */
    protected $products;

    /**
     * Налаштування для тестів
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Створюємо тестову категорію
        $this->category = Category::factory()->create(
            [
                'name' => 'Сири',
                'description' => 'Різноманітні сири високої якості'
            ]
        );
        
        // Створюємо кілька продуктів у категорії
        $this->products = [];
        for ($i = 1; $i <= 3; $i++) {
            $this->products[] = Product::factory()->create(
                [
                    'name' => "Сир #{$i}",
                    'price' => 50 + ($i * 10),
                    'description' => "Опис сиру #{$i}",
                    'category_id' => $this->category->id
                ]
            );
        }
    }

    /**
     * Тест перегляду сторінки категорії
     *
     * @return void
     */
    public function testCategoryPageDisplaysAllProducts()
    {
        $response = $this->get("/category/{$this->category->id}");
        
        $response->assertStatus(200);
        $response->assertSee($this->category->name);
        
        // Перевіряємо наявність продуктів категорії за назвою
        foreach ($this->products as $product) {
            $response->assertSee($product->name);
        }
    }

    /**
     * Тест, що пуста категорія відображається коректно
     *
     * @return void
     */
    public function testEmptyCategoryPage()
    {
        // Створюємо нову порожню категорію
        $emptyCategory = Category::factory()->create(
            [
                'name' => 'Пуста категорія',
                'description' => 'Ця категорія не містить продуктів'
            ]
        );
        
        $response = $this->get("/category/{$emptyCategory->id}");
        
        $response->assertStatus(200);
        $response->assertSee($emptyCategory->name);
        
        // Перевіряємо що сторінка взагалі відображається
        $response->assertViewIs('category');
    }

    /**
     * Тест, що неіснуюча категорія повертає 404
     *
     * @return void
     */
    public function testNonexistentCategoryReturns404()
    {
        // Використовуємо ID, який гарантовано не існує
        $nonExistentId = 9999;
        
        $response = $this->get("/category/{$nonExistentId}");
        
        $response->assertStatus(404);
    }
} 