<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin account (Librarian)
        User::updateOrCreate(
            ['email' => 'admin@library.com'],
            [
                'name' => 'Librarian Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // 2. Regular User account (Library Member)
        User::updateOrCreate(
            ['email' => 'user@library.com'],
            [
                'name' => 'John Reader (Member)',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}
