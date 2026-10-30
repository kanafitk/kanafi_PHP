<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cs = Category::where('name', 'Computer Science & Programming')->first();
        $fiction = Category::where('name', 'Fiction & Novels')->first();
        $science = Category::where('name', 'Science & Mathematics')->first();
        $business = Category::where('name', 'Business & Economics')->first();
        $history = Category::where('name', 'History & Philosophy')->first();

        $books = [
            [
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'category_id' => $cs?->id,
                'stock' => 12,
                'isbn' => '978-0132350884',
                'cover_image' => 'https://images.unsplash.com/photo-1532012164546-f432f2e3777a?auto=format&fit=crop&w=600&q=80',
                'description' => 'A handbook of agile software craftsmanship with best practices and refactoring techniques.'
            ],
            [
                'title' => 'Design Patterns: Elements of Reusable Object-Oriented Software',
                'author' => 'Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides',
                'category_id' => $cs?->id,
                'stock' => 8,
                'isbn' => '978-0201633610',
                'cover_image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80',
                'description' => 'Classic Gang of Four book on design patterns for robust software architecture.'
            ],
            [
                'title' => 'Laravel: Up & Running: A Framework for Building Modern PHP Apps',
                'author' => 'Matt Stauffer',
                'category_id' => $cs?->id,
                'stock' => 15,
                'isbn' => '978-1492041214',
                'cover_image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&w=600&q=80',
                'description' => 'Comprehensive guide to Laravel covering routing, Eloquent, validation, and Blade templating.'
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'category_id' => $fiction?->id,
                'stock' => 20,
                'isbn' => '978-0743273565',
                'cover_image' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&w=600&q=80',
                'description' => 'A story of ambition, love, wealth, and tragedy set in the Roaring Twenties.'
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'category_id' => $fiction?->id,
                'stock' => 10,
                'isbn' => '978-0061120084',
                'cover_image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80',
                'description' => 'An unforgettable novel of a childhood in a sleepy Southern town and justice in America.'
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'category_id' => $science?->id,
                'stock' => 14,
                'isbn' => '978-0553380163',
                'cover_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=600&q=80',
                'description' => 'An exploration of cosmology, black holes, the Big Bang, and the nature of time.'
            ],
            [
                'title' => 'Zero to One: Notes on Startups, or How to Build the Future',
                'author' => 'Peter Thiel, Blake Masters',
                'category_id' => $business?->id,
                'stock' => 9,
                'isbn' => '978-0804139298',
                'cover_image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=600&q=80',
                'description' => 'Insights and philosophy on creating unique innovations and building defensible monopolies.'
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'category_id' => $history?->id,
                'stock' => 18,
                'isbn' => '978-0062316097',
                'cover_image' => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?auto=format&fit=crop&w=600&q=80',
                'description' => 'A narrative of how an insignificant ape became the ruler of planet Earth.'
            ],
        ];

        foreach ($books as $book) {
            if ($book['category_id']) {
                Book::firstOrCreate(['title' => $book['title']], $book);
            }
        }
    }
}
