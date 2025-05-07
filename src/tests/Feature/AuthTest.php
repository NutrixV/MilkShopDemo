<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

/**
 * Клас тестів для перевірки автентифікації
 *
 * @category Tests
 * @package  MilkShopV2
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест для перевірки створення користувача через фабрику
     *
     * @return void
     */
    public function testCustomerFactoryCreatesValidCustomer()
    {
        $customer = Customer::factory()->create(
            [
                'email' => 'test-factory@example.com',
                'name' => 'Factory Test User',
                'password' => Hash::make('password123'),
            ]
        );
        
        $this->assertDatabaseHas(
            'customers',
            [
                'email' => 'test-factory@example.com',
                'name' => 'Factory Test User',
            ]
        );
        
        $this->assertTrue(Hash::check('password123', $customer->password));
    }

    /**
     * Тест для перевірки, що паролі хешуються правильно
     *
     * @return void
     */
    public function testCustomerPasswordIsHashed()
    {
        $plainPassword = 'secure_password123';
        
        $customer = Customer::factory()->create(
            [
                'password' => Hash::make($plainPassword),
            ]
        );
        
        // Перевіряємо, що пароль не зберігається у відкритому вигляді
        $this->assertNotEquals($plainPassword, $customer->password);
        
        // Перевіряємо, що хеш можна перевірити
        $this->assertTrue(Hash::check($plainPassword, $customer->password));
        
        // Перевіряємо, що неправильний пароль не проходить перевірку
        $this->assertFalse(Hash::check('wrong_password', $customer->password));
    }
    
    /**
     * Тест для перевірки унікальності email адреси
     *
     * @return void
     */
    public function testCustomerEmailMustBeUnique()
    {
        $email = 'unique-test@example.com';
        
        // Створюємо першого користувача
        Customer::factory()->create(
            [
                'email' => $email,
            ]
        );
        
        // Очікуємо виняток при створенні другого користувача з тією ж email
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        // Створюємо другого користувача з тим самим email
        Customer::factory()->create(
            [
                'email' => $email,
            ]
        );
    }
} 