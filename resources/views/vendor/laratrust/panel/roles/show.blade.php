@extends('laratrust::panel.layout')

@section('title', 'Просмотр роли')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $role->name }}</h1>
    </div>

    <div class="bg-white p-6 rounded-lg shadow space-y-6">
        <!-- Основная информация -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Основные данные</h2>
                <dl class="mt-2 space-y-2">
                    <div class="flex items-center">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Название:</dt>
                        <dd class="text-sm text-gray-900">{{ $role->name }}</dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Отображаемое имя:</dt>
                        <dd class="text-sm text-gray-900">{{ $role->display_name ?? 'Не указано' }}</dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Описание:</dt>
                        <dd class="text-sm text-gray-900">{{ $role->description ?? 'Не указано' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Связанные проекты -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Проекты</h2>
                @if($role->projects->isNotEmpty())
                    <ul class="mt-2 space-y-2">
                        @foreach($role->projects as $project)
                            <li class="text-sm text-gray-700">
                                <span class="font-medium">{{ $project->name }}</span>
                                @if($project->pivot->permissions)
                                    <span class="text-xs text-gray-500">({{ count(json_decode($project->pivot->permissions)) }} прав)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-2 text-sm text-gray-500">Проекты не назначены</p>
                @endif
            </div>
        </div>

        <!-- Права -->
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Права</h2>
            @if($role->permissions->isNotEmpty())
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($role->permissions as $permission)
                        <div class="bg-gray-100 p-3 rounded-md">
                            <p class="text-sm font-medium text-gray-900">{{ $permission->display_name ?? $permission->name }}</p>
                            <p class="text-xs text-gray-600">{{ $permission->name }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-2 text-sm text-gray-500">Права не назначены</p>
            @endif
        </div>

        <!-- Кнопки действий -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('laratrust.roles.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                Назад
            </a>
            <a href="{{ route('laratrust.roles.edit', $role) }}" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Редактировать
            </a>
        </div>
    </div>
@endsection
