@extends('laratrust::panel.layout')

@section('title', 'Список разрешений')

@section('content')
    <div x-data="{ openCreateModal: false, openEditModal: false, editId: null, editName: '', editDisplayName: '', editDescription: '' }">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Разрешения</h1>
        </div>

        <!-- Кнопка создания -->
        <div class="mb-6">
            <button @click="openCreateModal = true" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                Создать разрешение
            </button>
        </div>

        <!-- Таблица разрешений -->
        <div class="bg-white p-6 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Отображаемое имя</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Описание</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($permissions as $permission)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $permission->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $permission->display_name ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $permission->description ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <button @click="openEditModal = true; editId = {{ $permission->id }}; editName = '{{ $permission->name }}'; editDisplayName = '{{ $permission->display_name }}'; editDescription = '{{ $permission->description }}'"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                                Редактировать
                            </button>
                            <form action="{{ route('laratrust.permissions.delete', $permission) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200" onclick="return confirm('Удалить разрешение?')">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Разрешений не найдено</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $permissions->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Модальное окно для создания -->
        <div x-show="openCreateModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Создать разрешение</h2>
                <form method="POST" action="{{ route('laratrust.permissions.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="create_name" class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="name" id="create_name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="create_display_name" class="block text-sm font-medium text-gray-700">Отображаемое имя</label>
                        <input type="text" name="display_name" id="create_display_name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="create_description" class="block text-sm font-medium text-gray-700">Описание</label>
                        <textarea name="description" id="create_description" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" @click="openCreateModal = false" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                            Отмена
                        </button>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                            Создать
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Модальное окно для редактирования -->
        <div x-show="openEditModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Редактировать разрешение</h2>
                <form method="POST" :action="'{{ route('laratrust.permissions.update', '') }}/' + editId">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_name" class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="name" id="edit_name" x-model="editName" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_display_name" class="block text-sm font-medium text-gray-700">Отображаемое имя</label>
                        <input type="text" name="display_name" id="edit_display_name" x-model="editDisplayName" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700">Описание</label>
                        <textarea name="description" id="edit_description" x-model="editDescription" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" @click="openEditModal = false" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                            Отмена
                        </button>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                            Обновить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
