<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Спочатку видалимо всі продукти для чистого тесту
        \App\Models\Product::truncate();
        
        $faker = Faker::create('uk_UA');

        $productsByCategory = [
            1 => ['Молоко свіже 3.2%', 'Молоко ультрапастеризоване 2.5%', 'Молоко безлактозне 1.5%', 'Молоко фермерське 4.0%', 'Молоко органічне 3.6%'],
            2 => ['Сир твердий «Гауда»', 'Сир мякий «Альметте»', 'Сир плавлений «Дружба»', 'Сир «Едам»', 'Сир «Брі»'],
            3 => ['Кефір класичний 2.5%', 'Кефір нежирний 1.0%', 'Кефір біфідо 3.2%', 'Кефір дитячий', 'Кефір органічний'],
            4 => ['Йогурт полуничний', 'Йогурт натуральний', 'Йогурт злаковий', 'Йогурт манго', 'Йогурт чорничний'],
            5 => ['Масло селянське 72%', 'Масло фермерське 82%', 'Масло безлактозне', 'Масло солоне', 'Масло органічне'],
            6 => ['Сметана 20%', 'Сметана 15%', 'Сметана органічна', 'Сметана класична', 'Сметана фермерська'],
            7 => ['Ряжанка домашня', 'Ряжанка пастеризована', 'Ряжанка з медом', 'Ряжанка органічна', 'Ряжанка класична'],
            8 => ['Творог зернистий', 'Творог класичний', 'Творог з родзинками', 'Творог нежирний', 'Творог фермерський'],
            9 => ['Вершки 10%', 'Вершки 20%', 'Вершки збиті', 'Вершки кавові', 'Вершки органічні'],
            10 => ['Пудинг ванільний', 'Пудинг шоколадний', 'Крем-сир з ягодами', 'Молочний десерт банановий', 'Мус вершковий']
        ];

        $manufacturers = [
            'Молокія', 'Яготинське', 'Галичина', 'Простоквашино', 'Волошкове поле', 
            'Ферма Гадз', 'Селянське', 'Органік Мілк', 'Рудь', 'Добряна'
        ];

        foreach ($productsByCategory as $categoryId => $products) {
            foreach ($products as $index => $baseName) {
                // Створюємо один продукт без додаткового індексу
                \App\Models\Product::create([
                    'category_id' => $categoryId,
                    'name' => $baseName,
                    'description' => "Якісний молочний продукт категорії " . \App\Models\Category::find($categoryId)->name . ". " . $faker->sentence(8),
                    'price' => rand(1500, 15000) / 100,
                    'image_path' => null,
                    'in_stock' => $faker->boolean(90),
                    'fat_content' => $faker->randomElement(['0.5%', '1.5%', '2.5%', '3.2%', '6.0%']),
                    'volume' => $faker->randomElement([250, 500, 1000]),
                    'unit' => $faker->randomElement(['ml', 'g']),
                    'expiration_date' => $faker->dateTimeBetween('+5 days', '+30 days')->format('Y-m-d'),
                    'manufacturer' => $manufacturers[$index % count($manufacturers)],
                    'storage_temp' => '0-5°C',
                    'is_organic' => $faker->boolean(30),
                ]);
                
                // Додатково створюємо ще 2 варіанти кожного продукту з брендами виробників
                for ($i = 0; $i < 2; $i++) {
                    $manufacturer = $manufacturers[array_rand($manufacturers)];
                    $productName = $baseName . ' "' . $manufacturer . '"';
                    
                    \App\Models\Product::create([
                        'category_id' => $categoryId,
                        'name' => $productName,
                        'description' => "Від виробника " . $manufacturer . ". " . $faker->sentence(8),
                        'price' => rand(1500, 15000) / 100,
                        'image_path' => null,
                        'in_stock' => $faker->boolean(90),
                        'fat_content' => $faker->randomElement(['0.5%', '1.5%', '2.5%', '3.2%', '6.0%']),
                        'volume' => $faker->randomElement([250, 500, 1000]),
                        'unit' => $faker->randomElement(['ml', 'g']),
                        'expiration_date' => $faker->dateTimeBetween('+5 days', '+30 days')->format('Y-m-d'),
                        'manufacturer' => $manufacturer,
                        'storage_temp' => '0-5°C',
                        'is_organic' => $faker->boolean(30),
                    ]);
                }
            }
        }
        
        // Додаємо спеціальні продукти для тестування пошуку
        \App\Models\Product::create([
            'category_id' => 1,
            'name' => 'Молоко преміум класу',
            'description' => 'Ідеальне для пошуку за словом "молоко"',
            'price' => 120.50,
            'image_path' => null,
            'in_stock' => true,
            'fat_content' => '3.2%',
            'volume' => 1000,
            'unit' => 'ml',
            'expiration_date' => now()->addDays(14)->format('Y-m-d'),
            'manufacturer' => 'Тестова молочарня',
            'storage_temp' => '0-5°C',
            'is_organic' => true,
        ]);
    }
}
