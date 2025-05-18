<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Jawa',
            ],
            [
                'name' => 'Sumatera',
            ],
            [
                'name' => 'Kalimantan',
            ],
        ];

        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}