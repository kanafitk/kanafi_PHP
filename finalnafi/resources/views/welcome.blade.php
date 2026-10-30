<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library Management System - Laravel 13 Final Exam</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- Top Navigation -->
    <header class="w-full bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">📚</span>
                <span class="font-extrabold text-xl text-slate-900 tracking-tight">Library<span class="text-indigo-600">MS</span></span>
                <span class="hidden sm:inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">Laravel 13</span>
            </div>

            <div class="flex items-center space-x-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-xs transition">
                            Enter Dashboard &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 px-3 py-2 transition">
                            Log In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-xs transition">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span> Final Exam Project: Complete &amp; Verified
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-tight">
                        Modern Library <br>
                        <span class="text-indigo-600">Management System</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 max-w-xl leading-relaxed">
                        A robust, full-featured cataloging system engineered with Laravel 13. Includes secure user authentication, relational database architecture (Categories &amp; Books), instant keyword search, multi-criteria filtering, and complete CRUD operations.
                    </p>

                    <div class="flex flex-wrap gap-4 pt-2">
                        @auth
                            <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition">
                                📖 Open Books Catalog
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition">
                                🔑 Log In to System
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 font-bold rounded-xl shadow-xs transition">
                                📝 Create New Account
                            </a>
                        @endauth
                    </div>

                    <!-- Demo Credentials Card -->
                    <div class="p-4 rounded-xl bg-amber-50/80 border border-amber-200/90 max-w-lg mt-6 text-sm">
                        <div class="font-bold text-amber-950 flex items-center mb-2">
                            <span class="mr-1.5">⚡</span> Pre-seeded Demo Credentials (Role-Based):
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="bg-white/80 p-2.5 rounded-lg border border-amber-200">
                                <span class="font-bold text-indigo-700 block mb-1">👑 Admin (Librarian)</span>
                                <div>Email: <strong class="text-slate-900 font-mono">admin@library.com</strong></div>
                                <div>Pass: <strong class="text-slate-900 font-mono">password</strong></div>
                                <span class="text-[11px] text-slate-500 mt-1 block">Full CRUD on books &amp; categories</span>
                            </div>
                            <div class="bg-white/80 p-2.5 rounded-lg border border-amber-200">
                                <span class="font-bold text-emerald-700 block mb-1">👤 Member (Regular User)</span>
                                <div>Email: <strong class="text-slate-900 font-mono">user@library.com</strong></div>
                                <div>Pass: <strong class="text-slate-900 font-mono">password</strong></div>
                                <span class="text-[11px] text-slate-500 mt-1 block">Browse, search &amp; filter catalog</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Features Card) -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
                        <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">
                            Exam Requirements Met:
                        </h2>

                        <div class="space-y-4 text-sm">
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mr-3 font-bold">
                                    ✓
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">1. Authentication System</div>
                                    <div class="text-xs text-slate-500">Secure Laravel Breeze login, registration, password hashing, and session management.</div>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mr-3 font-bold">
                                    ✓
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">2. Relational Migrations &amp; Models</div>
                                    <div class="text-xs text-slate-500">Foreign key constraints connecting Categories (hasMany) and Books (belongsTo) with cascading deletes.</div>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mr-3 font-bold">
                                    ✓
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">3. Search &amp; Filter CRUD</div>
                                    <div class="text-xs text-slate-500">Real-time keyword search (title, author, ISBN) and dropdown filtering (category, stock status, sorting).</div>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mr-3 font-bold">
                                    ✓
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">4. GitHub Ready</div>
                                    <div class="text-xs text-slate-500">Clean Git commit history, proper .gitignore ignoring sensitive vendor and .env files.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            Library Management System &bull; Project Final Exam Laravel 13 &bull; Built with Laravel &amp; Tailwind CSS
        </div>
    </footer>

</body>
</html>
