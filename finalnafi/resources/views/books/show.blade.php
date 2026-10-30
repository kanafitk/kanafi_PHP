<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Book Details') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Full profile of selected library resource</p>
            </div>
            <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 uppercase tracking-widest hover:bg-gray-50 shadow-2xs">
                &larr; Back to Catalog
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-gray-100 pb-6">
                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            <div class="w-32 h-44 sm:w-40 sm:h-56 rounded-xl bg-slate-100 border border-slate-200 shadow-md overflow-hidden shrink-0 flex items-center justify-center">
                                @if ($book->cover_url)
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center p-4">
                                        <div class="text-4xl mb-2">📚</div>
                                        <span class="text-xs text-slate-400 font-medium">No Cover Image</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 mb-2">
                                    {{ $book->category->name ?? 'Uncategorized' }}
                                </span>
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-snug">{{ $book->title }}</h1>
                                <p class="text-base text-gray-600 mt-1">By <span class="font-semibold text-gray-900">{{ $book->author }}</span></p>
                            </div>
                        </div>

                        <!-- Stock Badge -->
                        <div>
                            @if ($book->stock > 5)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    ● {{ $book->stock }} Copies Available
                                </span>
                            @elseif ($book->stock > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    ⚠ {{ $book->stock }} Copies Left (Low Stock)
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                    ✕ Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Metadata Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 py-6 border-b border-gray-100 text-sm">
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-400 tracking-wider">ISBN Number</div>
                            <div class="mt-1 font-mono text-gray-900 font-medium">{{ $book->isbn ?? 'Not Provided' }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Date Added</div>
                            <div class="mt-1 text-gray-900 font-medium">{{ $book->created_at->format('M d, Y - H:i') }}</div>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Last Modified</div>
                            <div class="mt-1 text-gray-900 font-medium">{{ $book->updated_at->format('M d, Y - H:i') }}</div>
                        </div>
                    </div>

                    <!-- Synopsis / Description -->
                    <div class="py-6">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-2">Synopsis & Description</h3>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm bg-gray-50 p-4 rounded-lg border border-gray-100">
                            {{ $book->description ?: 'No synopsis or description has been provided for this book yet.' }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <a href="{{ route('books.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                            &larr; Back to all books
                        </a>
                        @if (Auth::user()->isAdmin())
                            <div class="flex items-center gap-3">
                                <a href="{{ route('books.edit', $book) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-xs transition">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Book
                                </a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-sm font-semibold transition cursor-pointer">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Book
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-xs font-semibold text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                                📌 To borrow or reserve this book, please contact your library desk with the ISBN: <span class="font-mono text-gray-800">{{ $book->isbn ?: 'N/A' }}</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
