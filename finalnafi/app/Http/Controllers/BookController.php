<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of books with search and filter.
     */
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Search by title or author
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'available') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        match ($sortBy) {
            'oldest' => $query->oldest(),
            'title_asc' => $query->orderBy('title', 'asc'),
            'title_desc' => $query->orderBy('title', 'desc'),
            'stock_high' => $query->orderBy('stock', 'desc'),
            'stock_low' => $query->orderBy('stock', 'asc'),
            default => $query->latest(),
        };

        $books = $query->paginate(8)->withQueryString();
        $categories = Category::withCount('books')->orderBy('name')->get();

        // Summary statistics
        $stats = [
            'total_titles' => Book::count(),
            'total_stock' => Book::sum('stock'),
            'total_categories' => Category::count(),
            'out_of_stock' => Book::where('stock', '<=', 0)->count(),
        ];

        return view('books.index', compact('books', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Unauthorized. Administrator privileges required.');
        }

        $categories = Category::orderBy('name')->get();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Unauthorized. Administrator privileges required.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
            'isbn' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book = Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', "Book '{$book->title}' has been added successfully!");
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book)
    {
        $book->load('category');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Unauthorized. Administrator privileges required.');
        }

        $categories = Category::orderBy('name')->get();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Unauthorized. Administrator privileges required.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
            'isbn' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && ! str_starts_with($book->cover_image, 'http')) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', "Book '{$book->title}' has been updated successfully!");
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Unauthorized. Administrator privileges required.');
        }

        if ($book->cover_image && ! str_starts_with($book->cover_image, 'http')) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $title = $book->title;
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', "Book '{$title}' has been deleted successfully!");
    }
}
