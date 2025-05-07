<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * Тест головної сторінки
     *
     * @return void
     */
    public function test_homepage_loads_correctly(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Тест сторінки каталогу
     *
     * @return void
     */
    public function test_catalog_page_loads(): void
    {
        $response = $this->get('/category');

        $response->assertStatus(200);
    }

    /**
     * Тест сторінки "Про нас"
     *
     * @return void
     */
    public function test_about_page_loads(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }
} 