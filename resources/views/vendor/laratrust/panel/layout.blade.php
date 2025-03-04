<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/vendor/laratrust/img/logo.png">
    <title>Laratrust - @yield('title')</title>
    <!-- Подключение Tailwind CSS через CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
<div>
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center h-16">
                <div class="flex items-center">
                    <div class="hidden md:block">
                        <div class="flex items-baseline space-x-4">
                            <a href="{{ config('laratrust.panel.go_back_route') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">← Go Back</a>
                            <a href="{{ route('laratrust.roles-assignment.index') }}"
                               class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->is('*roles-assignment*') ? 'bg-gray-900 text-white' : '' }}">
                                Roles & Permissions Assignment
                            </a>
                            <a href="{{ route('laratrust.roles.index') }}"
                               class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->is('*roles') ? 'bg-gray-900 text-white' : '' }}">
                                Roles
                            </a>
                            <a href="{{ route('laratrust.permissions.index') }}"
                               class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->is('*permissions*') ? 'bg-gray-900 text-white' : '' }}">
                                Permissions
                            </a>
                        </div>
                    </div>
                    <div class="ml-10 flex-shrink-0">
                        <!-- SVG логотип остаётся без изменений -->
                        <svg class="h-10 w-auto" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" height="80" width="272" version="1.1" viewBox="0 0 272 80">
                            <!-- Весь SVG код остаётся -->
                        </svg>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
                        <svg class="block h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 sm:px-3">
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900">Dashboard</a>
                <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Team</a>
                <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Projects</a>
                <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Calendar</a>
                <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Reports</a>
            </div>
        </div>
    </nav>

    <header class="bg-white shadow">
        <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                @yield('title')
            </h1>
        </div>
    </header>
    <main>
        <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
            @foreach (['error', 'warning', 'success'] as $msg)
                @if(Session::has('laratrust-' . $msg))
                    <div class="bg-{{ $msg == 'error' ? 'red' : ($msg == 'warning' ? 'yellow' : 'green') }}-100 border border-{{ $msg == 'error' ? 'red' : ($msg == 'warning' ? 'yellow' : 'green') }}-400 text-{{ $msg == 'error' ? 'red' : ($msg == 'warning' ? 'yellow' : 'green') }}-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <p>{{ Session::get('laratrust-' . $msg) }}</p>
                    </div>
                @endif
            @endforeach
            <div class="px-4 py-6 sm:px-0">
                @yield('content')
            </div>
        </div>
    </main>
</div>
</body>
</html>
