<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Library Book Catalog') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Manage, search, and monitor books and inventory</p>
            </div>
            @if (Auth::user()->isAdmin())
                <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('Add New Book') }}
                </a>
            @else
                <div class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span> Member Portal (Catalog View)
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs flex items-center">
                    <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Book Titles</div>
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_titles']) }}</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs flex items-center">
                    <div class="p-3 rounded-lg bg-emerald-50 text-emerald-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Total Stock in Library</div>
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_stock']) }}</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs flex items-center">
                    <div class="p-3 rounded-lg bg-amber-50 text-amber-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Active Categories</div>
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_categories']) }}</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs flex items-center">
                    <div class="p-3 rounded-lg bg-rose-50 text-rose-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Out of Stock</div>
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['out_of_stock']) }}</div>
                    </div>
                </div>
            </div>

            <!-- Search & Filters Container -->
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
                <form method="GET" action="{{ route('books.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                    
                    <!-- Search Input (Title, Author, ISBN) -->
                    <div class="md:col-span-4">
                        <label for="search" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Search Books</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by title, author, or ISBN..." class="pl-9 block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-2xs">
                        </div>
                    </div>

                    <!-- Filter by Category -->
                    <div class="md:col-span-3">
                        <label for="category_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Category</label>
                        <select name="category_id" id="category_id" class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-2xs">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->books_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Stock Status -->
                    <div class="md:col-span-2">
                        <label for="stock_status" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Availability</label>
                        <select name="stock_status" id="stock_status" class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-2xs">
                            <option value="">All Statuses</option>
                            <option value="available" {{ request('stock_status') === 'available' ? 'selected' : '' }}>In Stock (>0)</option>
                            <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock (0)</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="md:col-span-2">
                        <label for="sort" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Sort By</label>
                        <select name="sort" id="sort" class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-2xs">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Added</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest Added</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                            <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Highest Stock</option>
                        </select>
                    </div>

                    <!-- Submit & Reset Buttons -->
                    <div class="md:col-span-1 flex gap-1">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-2.5 bg-gray-900 hover:bg-gray-800 text-white rounded-lg text-sm font-semibold transition" title="Apply Filter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        </button>
                        @if (request()->hasAny(['search', 'category_id', 'stock_status', 'sort']))
                            <a href="{{ route('books.index') }}" class="inline-flex justify-center items-center px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition" title="Reset Filters">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Books Table -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Book Information</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Author</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ISBN</th>
                                <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($books as $book)
                                <tr class="hover:bg-gray-50/75 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start">
                                            <div class="w-12 h-16 rounded-md bg-slate-100 border border-slate-200 overflow-hidden shrink-0 mr-3 flex items-center justify-center shadow-2xs">
                                                @if ($book->cover_url)
                                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                                                @else
                                                    <div class="text-xl">📖</div>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('books.show', $book) }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition">
                                                    {{ $book->title }}
                                                </a>
                                                @if ($book->description)
                                                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-1 max-w-md">{{ $book->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                        {{ $book->author }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            {{ $book->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($book->stock > 5)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                ● {{ $book->stock }} available
                                            </span>
                                        @elseif ($book->stock > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                ⚠ {{ $book->stock }} left (low)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                ✕ Out of stock
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                        {{ $book->isbn ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('books.show', $book) }}" class="text-indigo-600 hover:text-indigo-900 font-medium" title="View Details">
                                            View Details
                                        </a>
                                        @if (Auth::user()->isAdmin())
                                            <span class="text-gray-300">|</span>
                                            <a href="{{ route('books.edit', $book) }}" class="text-indigo-600 hover:text-indigo-900 font-medium" title="Edit Book">
                                                Edit
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($book->title) }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-900 font-medium cursor-pointer">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="max-w-sm mx-auto">
                                            <div class="text-4xl mb-3">🔍</div>
                                            <h3 class="text-base font-semibold text-gray-900">No books found</h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                @if (request()->hasAny(['search', 'category_id', 'stock_status']))
                                                    Try adjusting your search keyword or clearing the filters.
                                                @else
                                                    No books in the library catalog yet.
                                                @endif
                                            </p>
                                            <div class="mt-4">
                                                @if (request()->hasAny(['search', 'category_id', 'stock_status']))
                                                    <a href="{{ route('books.index') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-semibold rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                        Clear Filters
                                                    </a>
                                                @elseif (Auth::user()->isAdmin())
                                                    <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-xs font-semibold text-white hover:bg-indigo-700">
                                                        Add Book
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($books->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
