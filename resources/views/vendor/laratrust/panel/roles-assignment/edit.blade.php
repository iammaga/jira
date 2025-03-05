@extends('laratrust::panel.layout')

@section('title', 'Редактирование ролей')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">Редактирование ролей пользователя: {{ $user->name }}</h1>

    <form method="POST" action="{{ route('laratrust.roles-assignment.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="roles" class="block text-sm font-medium text-gray-700">Роли</label>
            <div class="mt-2 space-y-2">
                @foreach ($roles as $role)
                    <div class="flex items-center">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}"
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                               @if($user->roles->contains($role)) checked @endif>
                        <label for="role-{{ $role->id }}" class="ml-2 text-sm text-gray-700">{{ $role->display_name ?? $role->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('laratrust.roles-assignment.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                Назад
            </a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Обновить</button>
        </div>
    </form>
@endsection
