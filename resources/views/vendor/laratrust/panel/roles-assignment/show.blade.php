@extends('laratrust::panel.layout')

@section('title', 'Просмотр ролей')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Роли пользователя: {{ $user->name }}</h1>
    </div>

    <div class="bg-white p-6 rounded-lg shadow space-y-6">
        <!-- Информация о пользователе -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Основные данные</h2>
                <dl class="mt-2 space-y-2">
                    <div class="flex items-center">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Имя:</dt>
                        <dd class="text-sm text-gray-900">{{ $user->name }}</dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Email:</dt>
                        <dd class="text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Роли:</dt>
                        <dd class="text-sm text-gray-900">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($user->roles as $role)
                                    <li>{{ $role->name }}, {{ $role->description }}</li>
                                @endforeach
                            </ul>
                        </dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Разрешения:</dt>
                        <dd class="text-sm text-gray-900">
                            @if ($user->permissions->isNotEmpty())
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($user->permissions as $permission)
                                        <li>{{ $permission->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-900">Нет разрешений</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Кнопки действий -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('laratrust.roles-assignment.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                Назад
            </a>
            <a href="{{ route('laratrust.roles-assignment.edit', $user->id) }}" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Редактировать
            </a>
        </div>
    </div>
@endsection
