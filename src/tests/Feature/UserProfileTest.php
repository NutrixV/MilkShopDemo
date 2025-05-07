<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

/**
 * Клас тестів для перевірки профілю користувача
 *
 * @category Tests
 * @package  MilkShopV2
 */
class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест створення користувача
     *
     * @return void
     */
    public function testCustomerCanBeCreated()
    {
        $customer = Customer::factory()->create(
            [
                'name' => 'Іван Петренко',
                'email' => 'ivan@example.com',
                'password' => Hash::make('password123')
            ]
        );
        
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('Іван Петренко', $customer->name);
        $this->assertEquals('ivan@example.com', $customer->email);
        
        $this->assertDatabaseHas(
            'customers',
            [
                'name' => 'Іван Петренко',
                'email' => 'ivan@example.com'
            ]
        );
    }
    
    /**
     * Тест перевірки хешування паролю
     *
     * @return void
     */
    public function testCustomerPasswordIsHashed()
    {
        $password = 'секретний_пароль';
        
        $customer = Customer::factory()->create(
            [
                'password' => Hash::make($password)
            ]
        );
        
        $this->assertTrue(Hash::check($password, $customer->password));
        $this->assertFalse(Hash::check('невірний_пароль', $customer->password));
    }
} 