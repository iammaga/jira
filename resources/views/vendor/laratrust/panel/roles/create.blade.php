@extends('laratrust::panel.layout')

@section('title', 'Создание роли')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Создать роль</h1>
    </div>

    <form method="POST" action="{{ route('laratrust.roles.store') }}" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Название</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
            @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="display_name" class="block text-sm font-medium text-gray-700">Отображаемое имя</label>
            <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('display_name') border-red-500 @enderror">
            @error('display_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
            <textarea name="description" id="description" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" rows="4">{{ old('description') }}</textarea>
            @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="project_id" class="block text-sm font-medium text-gray-700">Проект</label>
            <select name="project_id" id="project_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror">
                <option value="">Без проекта (глобальная роль)</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
            @error('project_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Права</label>
            <div class="mt-2 space-y-4">
                @foreach ($permissions as $group => $perms)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $group }}</h3>
                        <div class="mt-2 space-y-2">
                            @foreach ($perms as $permission)
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm-{{ $permission->id }}"
                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="perm-{{ $permission->id }}" class="ml-2 text-sm text-gray-700">{{ $permission->display_name ?? $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            @error('permissions')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('laratrust.roles.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                Отмена
            </a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition duration-200">
                Создать
            </button>
        </div>
    </form>
@endsection
