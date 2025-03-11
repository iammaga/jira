@extends('laratrust::panel.layout')

@section('title', 'Назначение ролей')

@section('content')
    <div x-data="{ openAssignModal: false }">
        <!-- Заголовок -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-user-tag mr-2"></i> Роли
            </h1>
            <!-- Кнопка назначения ролей -->
            <button @click="openAssignModal = true"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200 flex items-center"
                    title="Назначить роли">
                <i class="fas fa-user-plus md:mr-0 py-2"></i>
            </button>
        </div>

        <!-- Модальное окно для назначения ролей -->
        <div x-show="openAssignModal"
             x-cloak
             class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
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
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Разрешения</label>
                        <div class="mt-2 space-y-2">
                            @foreach ($permissions as $permission)
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}"
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-700">{{ $permission->display_name ?? $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
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
        <div class="bg-white p-4 md:p-6 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-user mr-1"></i> Пользователь
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-user-tag mr-1"></i> Роли
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-lock mr-1"></i> Разрешения
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-cogs mr-1"></i> Действия
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 md:px-6 md:py-4 text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-sm text-gray-700 hidden md:table-cell">
                            {{ $user->roles->pluck('name')->implode(', ') }}
                        </td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-sm text-gray-700 hidden md:table-cell">
                            {{ $user->permissions->isNotEmpty() ? $user->permissions->pluck('name')->implode(', ') : 'Нет разрешений' }}
                        </td>
                        <td class="px-4 py-3 md:px-6 md:py-4 flex space-x-2 items-center">
                            <a href="{{ route('laratrust.roles-assignment.show', $user->id) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 flex items-center"
                               title="Просмотр">
                                <i class="fas fa-eye md:mr-0 py-2"></i>
                            </a>
                            <a href="{{ route('laratrust.roles-assignment.edit', $user->id) }}"
                               class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200 flex items-center"
                               title="Редактировать">
                                <i class="fas fa-edit md:mr-0 py-2"></i>
                            </a>
                            <form action="{{ route('laratrust.roles-assignment.remove', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 flex items-center"
                                        title="Удалить"
                                        onclick="return confirm('Удалить назначение ролей?')">
                                    <i class="fas fa-trash-alt md:mr-0 py-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 md:px-6 md:py-4 text-center text-gray-500 text-sm">Пользователи не найдены</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-6 flex justify-center">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
