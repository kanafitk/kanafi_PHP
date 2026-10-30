<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->user = User::factory()->create(); // default role: 'user'

        $this->category = Category::create([
            'name' => 'Computer Science',
            'description' => 'Programming and tech books',
        ]);
    }

    public function test_guests_cannot_view_books(): void
    {
        $response = $this->get('/books');
        $response->assertRedirect('/login');
    }

    public function test_regular_user_can_view_books_list(): void
    {
        Book::create([
            'title' => 'Test Book Title',
            'author' => 'John Doe',
            'category_id' => $this->category->id,
            'stock' => 10,
        ]);

        $response = $this->actingAs($this->user)->get('/books');
        $response->assertStatus(200);
        $response->assertSee('Test Book Title');
        $response->assertSee('Computer Science');
        // Regular user should not see "+ Add New Book" button
        $response->assertDontSee('Add New Book');
    }

    public function test_admin_sees_add_book_button(): void
    {
        $response = $this->actingAs($this->admin)->get('/books');
        $response->assertStatus(200);
        $response->assertSee('Add New Book');
    }

    public function test_can_search_book_by_title(): void
    {
        Book::create([
            'title' => 'Laravel Mastery',
            'author' => 'Taylor Otwell',
            'category_id' => $this->category->id,
            'stock' => 5,
        ]);

        Book::create([
            'title' => 'Cooking 101',
            'author' => 'Chef Gordon',
            'category_id' => $this->category->id,
            'stock' => 5,
        ]);

        $response = $this->actingAs($this->user)->get('/books?search=Laravel');
        $response->assertStatus(200);
        $response->assertSee('Laravel Mastery');
        $response->assertDontSee('Cooking 101');
    }

    public function test_can_filter_books_by_category(): void
    {
        $otherCategory = Category::create(['name' => 'Fiction']);

        $book1 = Book::create([
            'title' => 'Tech Book',
            'author' => 'Author A',
            'category_id' => $this->category->id,
            'stock' => 5,
        ]);

        $book2 = Book::create([
            'title' => 'Novel Book',
            'author' => 'Author B',
            'category_id' => $otherCategory->id,
            'stock' => 5,
        ]);

        $response = $this->actingAs($this->user)->get('/books?category_id=' . $this->category->id);
        $response->assertStatus(200);
        $response->assertSee('Tech Book');
        $response->assertDontSee('Novel Book');
    }

    public function test_admin_can_create_a_book(): void
    {
        $response = $this->actingAs($this->admin)->post('/books', [
            'title' => 'New Architecture Book',
            'author' => 'Martin Fowler',
            'category_id' => $this->category->id,
            'stock' => 15,
            'isbn' => '978-1234567890',
            'description' => 'Great software design book.',
        ]);

        $response->assertRedirect('/books');
        $this->assertDatabaseHas('books', [
            'title' => 'New Architecture Book',
            'author' => 'Martin Fowler',
            'stock' => 15,
        ]);
    }

    public function test_admin_can_upload_book_with_cover_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('cover.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post('/books', [
            'title' => 'Book with Picture',
            'author' => 'Photographer',
            'category_id' => $this->category->id,
            'stock' => 5,
            'cover_image' => $file,
        ]);

        $response->assertRedirect('/books');
        
        $book = Book::where('title', 'Book with Picture')->first();
        $this->assertNotNull($book);
        $this->assertNotNull($book->cover_image);
        Storage::disk('public')->assertExists($book->cover_image);
    }

    public function test_regular_user_cannot_create_a_book(): void
    {
        $response = $this->actingAs($this->user)->post('/books', [
            'title' => 'Unauthorized Book',
            'author' => 'Hacker',
            'category_id' => $this->category->id,
            'stock' => 1,
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('books', ['title' => 'Unauthorized Book']);
    }

    public function test_admin_can_update_a_book(): void
    {
        $book = Book::create([
            'title' => 'Original Title',
            'author' => 'Original Author',
            'category_id' => $this->category->id,
            'stock' => 3,
        ]);

        $response = $this->actingAs($this->admin)->put("/books/{$book->id}", [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'category_id' => $this->category->id,
            'stock' => 7,
        ]);

        $response->assertRedirect('/books');
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'stock' => 7,
        ]);
    }

    public function test_regular_user_cannot_update_a_book(): void
    {
        $book = Book::create([
            'title' => 'Protected Book',
            'author' => 'Author Safe',
            'category_id' => $this->category->id,
            'stock' => 3,
        ]);

        $response = $this->actingAs($this->user)->put("/books/{$book->id}", [
            'title' => 'Malicious Edit',
            'author' => 'Author Safe',
            'category_id' => $this->category->id,
            'stock' => 10,
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('books', ['title' => 'Protected Book']);
    }

    public function test_admin_can_delete_a_book(): void
    {
        $book = Book::create([
            'title' => 'Book to Delete',
            'author' => 'Author X',
            'category_id' => $this->category->id,
            'stock' => 2,
        ]);

        $response = $this->actingAs($this->admin)->delete("/books/{$book->id}");
        $response->assertRedirect('/books');
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_regular_user_cannot_delete_a_book(): void
    {
        $book = Book::create([
            'title' => 'Book Cannot Be Deleted',
            'author' => 'Author Y',
            'category_id' => $this->category->id,
            'stock' => 2,
        ]);

        $response = $this->actingAs($this->user)->delete("/books/{$book->id}");
        $response->assertStatus(403);
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    public function test_model_relationships(): void
    {
        $book = Book::create([
            'title' => 'Relation Test',
            'author' => 'Author Y',
            'category_id' => $this->category->id,
            'stock' => 1,
        ]);

        $this->assertEquals($this->category->id, $book->category->id);
        $this->assertTrue($this->category->books->contains($book));
    }
}
