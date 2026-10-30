<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Book Categories') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Organize books into genres and subject departments</p>
            </div>
            <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 uppercase tracking-widest hover:bg-gray-50 shadow-2xs">
                &larr; View Books Catalog
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Add Category Form -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sticky top-6">
                        <h3 class="text-base font-bold text-gray-900 mb-1 flex items-center">
                            <span class="mr-2">🏷️</span> Add New Category
                        </h3>
                        <p class="text-xs text-gray-500 mb-5">Create a new classification category for books</p>

                        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Category Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-2xs"
                                    placeholder="e.g. Artificial Intelligence">
                                @error('name')
                                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Description (Optional)</label>
                                <textarea name="description" id="description" rows="3"
                                    class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-2xs"
                                    placeholder="Brief note about what belongs in this category...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-xs transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Save Category
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Categories List Table -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-bold text-gray-900 text-base">Existing Categories ({{ $categories->total() }})</h3>
                        </div>

                        <div class="divide-y divide-gray-200">
                            @forelse ($categories as $cat)
                                <div class="p-6 hover:bg-gray-50/75 transition-colors" x-data="{ editing: false }">
                                    <div x-show="!editing" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-base font-semibold text-gray-900">{{ $cat->name }}</h4>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                    {{ $cat->books_count }} {{ Str::plural('book', $cat->books_count) }}
                                                </span>
                                            </div>
                                            @if ($cat->description)
                                                <p class="text-xs text-gray-500 mt-1 max-w-xl">{{ $cat->description }}</p>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-2 shrink-0">
                                            <a href="{{ route('books.index', ['category_id' => $cat->id]) }}" class="text-xs font-semibold px-3 py-1.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Filter books in this category">
                                                Browse Books &rarr;
                                            </a>
                                            <button type="button" @click="editing = true" class="text-xs font-semibold px-3 py-1.5 rounded-md bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition">
                                                Edit
                                            </button>
                                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Deleting category \'{{ addslashes($cat->name) }}\' will also cascade delete its associated books. Continue?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-md bg-rose-50 hover:bg-rose-100 text-rose-700 transition cursor-pointer">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Inline Edit Form -->
                                    <div x-show="editing" x-cloak class="pt-2">
                                        <form action="{{ route('categories.update', $cat) }}" method="POST" class="space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-700">Name</label>
                                                <input type="text" name="name" value="{{ old('name', $cat->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-700">Description</label>
                                                <textarea name="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 text-sm">{{ old('description', $cat->description) }}</textarea>
                                            </div>
                                            <div class="flex items-center justify-end gap-2">
                                                <button type="button" @click="editing = false" class="px-3 py-1.5 border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-white">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-xs font-semibold">
                                                    Update Category
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center text-gray-500">
                                    No categories created yet. Use the form on the left to add one!
                                </div>
                            @endforelse
                        </div>

                        @if ($categories->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                {{ $categories->links() }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
