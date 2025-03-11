@extends('laratrust::panel.layout')

@section('title', 'Список проектов')

@section('content')
    <div x-data="{ openCreateModal: false, openEditModal: false, editId: null, editName: '', editKey: '', editDescription: '' }">
        <!-- Заголовок -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-folder mr-2"></i> Проекты
            </h1>
            <!-- Кнопка создания -->
            <button @click="openCreateModal = true"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200 flex items-center"
                    title="Создать проект">
                <i class="fas fa-plus md:mr-0 py-2"></i>
            </button>
        </div>

        <!-- Таблица проектов -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-heading mr-1"></i> Название
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-file-alt mr-1"></i> Описание
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-users mr-1"></i> Ролей
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-cogs mr-1"></i> Действия
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($projects as $project)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 md:px-6 md:py-4 text-gray-900 text-sm">{{ $project->name }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-gray-700 text-sm hidden md:table-cell">{{ $project->description ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-gray-700 text-sm hidden md:table-cell">{{ $project->roles_count }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 space-x-2 flex items-center">
                            <a href="{{ route('laratrust.projects.show', $project) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 flex items-center"
                               title="Просмотр">
                                <i class="fas fa-eye md:mr-0 py-2"></i>
                            </a>
                            <button @click="editId = {{ $project->id }}; editName = '{{ $project->name }}'; editKey = '{{ $project->key }}'; editDescription = '{{ $project->description ?? '' }}'; openEditModal = true"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200 flex items-center"
                                    title="Редактировать">
                                <i class="fas fa-edit md:mr-0 py-2"></i>
                            </button>
                            <form action="{{ route('laratrust.projects.delete', $project) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 flex items-center"
                                        title="Удалить"
                                        onclick="return confirm('Удалить проект?')">
                                    <i class="fas fa-trash-alt md:mr-0 py-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 md:px-6 md:py-4 text-center text-gray-500 text-sm">Проекты не найдены</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-6 flex justify-center">
                {{ $projects->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Модальное окно для создания -->
        <div x-show="openCreateModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
                <h2 class="text-xl font-bold mb-4">Создать проект</h2>
                <form method="POST" action="{{ route('laratrust.projects.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Описание</label>
                        <textarea name="description" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
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
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
                <h2 class="text-xl font-bold mb-4">Редактировать проект</h2>
                <form method="POST" :action="'{{ route('laratrust.projects.update', '') }}/' + editId">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="name" x-model="editName" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Описание</label>
                        <textarea name="description" x-model="editDescription" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
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
