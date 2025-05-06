<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Молоко', 'description' => 'Свіже пастеризоване та ультрапастеризоване молоко'],
            ['name' => 'Сир', 'description' => 'Тверді, мʼякі та плавлені сири різних сортів'],
            ['name' => 'Кефір', 'description' => 'Кисломолочні напої з пробіотиками'],
            ['name' => 'Йогурт', 'description' => 'Йогурти питні та десертні з різними смаками'],
            ['name' => 'Масло', 'description' => 'Масло вершкове різної жирності'],
            ['name' => 'Сметана', 'description' => 'Сметана для приготування страв або споживання окремо'],
            ['name' => 'Ряжанка', 'description' => 'Традиційний український кисломолочний продукт'],
            ['name' => 'Творог', 'description' => 'Домашній сир у різних варіаціях'],
            ['name' => 'Вершки', 'description' => 'Вершки для кави або приготування десертів'],
            ['name' => 'Десерти', 'description' => 'Молочні десерти: пудинги, креми, тощо'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(
                ['name' => $category['name']], // Field by which we search for an existing record
                $category // All fields for creation, if the record is not found
            );
        }
    }
}
