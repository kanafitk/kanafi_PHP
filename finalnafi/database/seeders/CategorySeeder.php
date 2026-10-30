<?php

namespace Database\Seeders;

use App\Models\Category;
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
            ['name' => 'Computer Science & Programming', 'description' => 'Software engineering, algorithms, web development, and AI.'],
            ['name' => 'Fiction & Novels', 'description' => 'Stories, novels, contemporary fiction, and classic literature.'],
            ['name' => 'Science & Mathematics', 'description' => 'Physics, biology, chemistry, calculus, and logic.'],
            ['name' => 'Business & Economics', 'description' => 'Management, entrepreneurship, finance, and marketing.'],
            ['name' => 'History & Philosophy', 'description' => 'World history, civilizations, philosophical treatises, and biographies.'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
