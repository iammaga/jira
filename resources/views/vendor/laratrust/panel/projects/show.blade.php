@extends('laratrust::panel.layout')

@section('title', 'Просмотр проекта')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Проект: {{ $project->name }}</h1>
    </div>

    <div class="bg-white p-6 rounded-lg shadow space-y-6">
        <!-- Информация о проекте -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Основные данные</h2>
                <dl class="mt-2 space-y-2">
                    <div class="flex items-center">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Описание:</dt>
                        <dd class="text-sm text-gray-900">{{ $project->description }}</dd>
                    </div>
                    <div class="flex items-center">
                        <dt class="w-1/3 text-sm font-medium text-gray-600">Роли:</dt>
                        <dd class="text-sm text-gray-900">
                            @if ($project->roles->isEmpty())
                                <p>У пользователя нет ролей.</p>
                            @else
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($project->roles as $role)
                                        <li>{{ $role->display_name ?? $role->name }} (Прав: {{ $role->permissions->count() }})</li>
                                    @endforeach
                                </ul>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Кнопки действий -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('laratrust.projects') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                Назад
            </a>
            <a href="{{ route('laratrust.projects.edit', $project) }}" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Редактировать
            </a>
        </div>
    </div>
@endsection
