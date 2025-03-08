@extends('laratrust::panel.layout')

@section('title', 'Список проектов')

@section('content')
    <div x-data="{ openCreateModal: false, openEditModal: false, editId: null, editName: '', editKey: '', editDescription: '' }">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Проекты</h1>
        </div>

        <!-- Кнопка создания -->
        <div class="mb-6">
            <button @click="openCreateModal = true"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                Создать проект
            </button>
        </div>

        <!-- Таблица проектов -->
        <div class="bg-white p-6 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ключ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Описание</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ролей</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($projects as $project)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 text-gray-900">{{ $project->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $project->key }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $project->description ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $project->roles_count }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('laratrust.projects.show', $project) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                                Просмотр
                            </a>
                            <button @click="editId = {{ $project->id }}; editName = '{{ $project->name }}'; editKey = '{{ $project->key }}'; editDescription = '{{ $project->description ?? '' }}'; openEditModal = true"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                                Редактировать
                            </button>
                            <form action="{{ route('laratrust.projects.delete', $project) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200"
                                        onclick="return confirm('Удалить проект?')">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Проекты не найдены</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $projects->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Модальное окно для создания -->
        <div x-show="openCreateModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Создать проект</h2>
                <form method="POST" action="{{ route('laratrust.projects.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Ключ</label>
                        <input type="text" name="key" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Описание</label>
                        <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
                    </div>
                    <div class="flex justify-end space-x-4 my-2">
                        <button type="button" @click="openCreateModal = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                            Отмена
                        </button>
                        <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                            Создать
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Модальное окно для редактирования -->
        <div x-show="openEditModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Редактировать проект</h2>
                <form method="POST" :action="'{{ route('laratrust.projects.update', '') }}/' + editId">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="name" x-model="editName" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Ключ</label>
                        <input type="text" name="key" x-model="editKey" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Описание</label>
                        <textarea name="description" x-model="editDescription" class="w-full border rounded px-3 py-2"></textarea>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" @click="openEditModal = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                            Отмена
                        </button>
                        <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                            Обновить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
