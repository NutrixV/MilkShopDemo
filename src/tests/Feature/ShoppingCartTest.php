<?php
/**
 * Тести для функціоналу кошика покупок
 * 
 * @category Tests
 * @package  MilkShopV2
 * @author   MilkShop Team <team@milkshop.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/milkshop/milkshop
 */

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

/**
 * Клас тестів для перевірки функціоналу кошика покупок
 *
 * @category Tests
 * @package  MilkShopV2
 * @author   MilkShop Team <team@milkshop.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/milkshop/milkshop
 */
class ShoppingCartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Продукт для тестування
     *
     * @var Product
     */
    protected $product;

    /**
     * Налаштування для тестів
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Шукаємо або створюємо тестову категорію
        $category = Category::where('name', 'Молоко для тестів')->first();
        if (!$category) {
            $category = Category::factory()->create(
                [
                    'name' => 'Молоко для тестів'
                ]
            );
        }
        
        // Створюємо тестовий продукт
        $this->product = Product::factory()->create(
            [
                'name' => 'Тестове молоко ' . uniqid(),
                'price' => 25.50,
                'description' => 'Опис тестового молока',
                'category_id' => $category->id
            ]
        );
    }

    /**
     * Тест що сесійний кошик зберігає дані коректно
     *
     * @return void
     */
    public function testCartSessionStorageWorks()
    {
        Session::put(
            'cart',
            [
                $this->product->id => [
                    'quantity' => 3,
                    'price' => $this->product->price
                ]
            ]
        );
        
        $cart = Session::get('cart');
        
        $this->assertIsArray($cart);
        $this->assertArrayHasKey($this->product->id, $cart);
        $this->assertEquals(3, $cart[$this->product->id]['quantity']);
        $this->assertEquals($this->product->price, $cart[$this->product->id]['price']);
    }
}
