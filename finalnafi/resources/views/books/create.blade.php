<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Add New Book') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Register a new book into the library management system</p>
            </div>
            <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 uppercase tracking-widest hover:bg-gray-50 shadow-2xs">
                &larr; Back to Books
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 sm:p-8">
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Book Cover Picture -->
                    <div x-data="{ photoName: null, photoPreview: null }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Book Cover Picture (Optional)</label>
                        <div class="mt-1 flex items-center gap-4">
                            <!-- Preview Box -->
                            <div class="w-20 h-28 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden bg-gray-50 text-gray-400 shrink-0">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-center p-2">
                                        <svg class="mx-auto h-7 w-7 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-[10px] block text-gray-500 mt-0.5">Cover</span>
                                    </div>
                                </template>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"
                                    @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            photoName = file.name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => { photoPreview = e.target.result; };
                                            reader.readAsDataURL(file);
                                        }
                                    ">
                                <p class="text-xs text-gray-500 mt-1">Upload JPEG, PNG, WEBP, or GIF (max 3MB).</p>
                                @error('cover_image')
                                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700">Book Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-2xs focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            placeholder="e.g. Clean Architecture">
                        @error('title')
                            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Author & Category in 2 cols -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Author -->
                        <div>
                            <label for="author" class="block text-sm font-semibold text-gray-700">Author Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="author" id="author" value="{{ old('author') }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-2xs focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                placeholder="e.g. Robert C. Martin">
                            @error('author')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">Category / Genre <span class="text-rose-500">*</span></label>
                            <select name="category_id" id="category_id" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-2xs focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock & ISBN in 2 cols -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Stock Quantity -->
                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-700">Stock Quantity <span class="text-rose-500">*</span></label>
                            <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', 1) }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-2xs focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <span class="text-xs text-gray-500">Available physical copies in library</span>
                            @error('stock')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ISBN -->
                        <div>
                            <label for="isbn" class="block text-sm font-semibold text-gray-700">ISBN Code (Optional)</label>
                            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-2xs focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                placeholder="e.g. 978-0134494166">
                            @error('isbn')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700">Description / Synopsis (Optional)</label>
                        <textarea name="description" id="description" rows="4"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-2xs focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            placeholder="Enter a brief summary or notes about the book...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('books.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
