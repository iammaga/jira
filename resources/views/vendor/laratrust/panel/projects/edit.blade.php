@extends('laratrust::panel.layout')

@section('title', 'Редактирование проекта')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Редактировать проект: {{ $project->name }}</h1>
    </div>

    <div class="bg-white p-6 rounded-lg shadow space-y-6">
        <form method="POST" action="{{ route('laratrust.projects.update', $project) }}">
            @csrf @method('PUT')

            <div class="space-y-4">
                <!-- Название -->
                <div class="form-group">
                    <label for="name" class="text-sm font-medium text-gray-700">Название</label>
                    <input type="text" name="name" id="name" value="{{ $project->name }}" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Ключ -->
                <div class="form-group">
                    <label for="key" class="text-sm font-medium text-gray-700">Ключ</label>
                    <input type="text" name="key" id="key" value="{{ $project->key }}" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Описание -->
                <div class="form-group">
                    <label for="description" class="text-sm font-medium text-gray-700">Описание</label>
                    <textarea name="description" id="description" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $project->description }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('laratrust.projects') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                    Отмена
                </a>
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition duration-200">
                    Обновить
                </button>
            </div>
        </form>
    </div>
@endsection
