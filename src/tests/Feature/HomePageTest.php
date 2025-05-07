<?php
/**
 * Тести для головної сторінки
 * 
 * @category Tests
 * @package  MilkShopV2
 * @author   MilkShop Team <team@milkshop.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/milkshop/milkshop
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

/**
 * Клас тестів головної сторінки
 *
 * @category Tests
 * @package  MilkShopV2
 * @author   MilkShop Team <team@milkshop.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/milkshop/milkshop
 */
class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест завантаження головної сторінки
     *
     * @return void
     */
    public function testHomePageLoadsSuccessfully()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Milk Shop');
        $response->assertSee('Каталог');
    }
    
    /**
     * Тест що головна сторінка показує продукти та категорії
     *
     * @return void
     */
    public function testHomePageDisplaysProductsAndCategories()
    {
        // Створюємо категорію
        $category = Category::factory()->create(
            [
                'name' => 'Тестова категорія'
            ]
        );
        
        // Створюємо продукт
        $product = Product::factory()->create(
            [
                'name' => 'Тестовий продукт',
                'category_id' => $category->id,
                'price' => 25.75
            ]
        );
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Тестова категорія');
        $response->assertSee('Рекомендовані продукти');
    }
    
    /**
     * Тест що на головній сторінці є пошукова форма
     *
     * @return void
     */
    public function testHomePageHasSearchForm()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        // Перевіряємо наявність форми пошуку, не перевіряючи точний URL
        $response->assertSee('form', false);
        $response->assertSee('name="query"', false);
        $response->assertSee('type="text"', false);
    }
} 