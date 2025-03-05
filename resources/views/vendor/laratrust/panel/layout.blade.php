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
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
{{--                    <div class="shrink-0 flex items-center">--}}
{{--                        <svg class="h-10 w-auto" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" height="80" width="272" version="1.1" viewBox="0 0 272 80">--}}
{{--                            <!-- Весь SVG код остаётся без изменений -->--}}
{{--                        </svg>--}}
{{--                    </div>--}}

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('/') ? 'border-indigo-400 text-gray-900 focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
                            ← Dashboard
                        </a>
                        <a href="{{ route('laratrust.roles.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('*roles') ? 'border-indigo-400 text-gray-900 focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
                            Roles
                        </a>
                        <a href="{{ route('laratrust.permissions.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('*permissions*') ? 'border-indigo-400 text-gray-900 focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
                            Permissions
                        </a>
                        <a href="{{ route('laratrust.roles-assignment.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('*roles-assignment*') ? 'border-indigo-400 text-gray-900 focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
                            Roles & Permissions Assignment
                        </a>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ config('laratrust.panel.go_back_route') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('/') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    ← Go Back
                </a>
                <a href="{{ route('laratrust.roles-assignment.index') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('*roles-assignment*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    Roles & Permissions Assignment
                </a>
                <a href="{{ route('laratrust.roles.index') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('*roles') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    Roles
                </a>
                <a href="{{ route('laratrust.permissions.index') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('*permissions*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    Permissions
                </a>
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
