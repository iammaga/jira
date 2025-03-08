@extends('laratrust::panel.layout')

@section('title', 'Назначение ролей')

@section('content')
    <div x-data="{ openAssignModal: false }">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Роли</h1>
        </div>

        <!-- Кнопка назначения ролей -->
        <div class="mb-6">
            <button @click="openAssignModal = true"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                Назначить роли
            </button>
        </div>

        <div x-show="openAssignModal"
             x-cloak
             class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Назначить роли</h2>
                <form method="POST" action="{{ route('laratrust.roles-assignment.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Выберите пользователя</label>
                        <select name="user_id" id="user_id"
                                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Выберите пользователя --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Роли</label>
                        <div class="mt-2 space-y-2">
                            @foreach ($roles as $role)
                                <div class="flex items-center">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}"
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="role-{{ $role->id }}" class="ml-2 text-sm text-gray-700">{{ $role->display_name ?? $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('roles')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button @click="openAssignModal = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                            Отмена
                        </button>
                        <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">Назначить
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Таблица текущих назначений -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Текущие назначения</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Пользователь</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Роли</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('laratrust.roles-assignment.show', $user->id) }}"
                                   class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Просмотр</a>
                                <a href="{{ route('laratrust.roles-assignment.edit', $user->id) }}"
                                   class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">Редактировать</a>
                                <form action="{{ route('laratrust.roles-assignment.revoke', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Пользователи не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
