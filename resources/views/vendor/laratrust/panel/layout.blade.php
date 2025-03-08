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
    <script src="//unpkg.com/alpinejs"></script>
</head>
<body>
<div>
    @include('layouts.navigation')

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
