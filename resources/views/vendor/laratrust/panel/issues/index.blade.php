@extends('laratrust::panel.layout')

@section('title', 'Список задач')

@section('content')
    <div x-data="{ openCreateModal: false, openEditModal: false, editId: null, editTitle: '', editDescription: '', editStatus: '', editProjectId: '', editTypeId: '', editPriorityId: ''}">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Задачи</h1>
        </div>

        <!-- Кнопка создания -->
        <div class="mb-6">
            <button @click="openCreateModal = true" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                Создать задачу
            </button>
        </div>

        <!-- Таблица задач -->
        <div class="bg-white p-6 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Описание</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Проект</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип задачи</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Приоритет</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Создано</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($issues as $issue)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $issue->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $issue->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $issue->description ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $issue->status->name ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $issue->project->name ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $issue->type->name ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $issue->priority->name ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $issue->createdBy->name ?? 'Неизвестно' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <button @click="editId = {{ $issue->id }}; editTitle = '{{ $issue->title }}'; editDescription = '{{ $issue->description ?? '' }}'; editStatus = '{{ $issue->status_id }}'; editProjectId = '{{ $issue->project_id }}'; editTypeId = '{{ $issue->type_id }}'; editPriorityId = '{{ $issue->priority_id }}'; openEditModal = true"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                                Редактировать
                            </button>
                            <form action="{{ route('laratrust.issues.delete', $issue) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200" onclick="return confirm('Удалить задачу?')">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">Задачи не найдены</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $issues->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Модальное окно для создания -->
        <div x-show="openCreateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" x-cloak>
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Создать задачу</h2>
                <form method="POST" action="{{ route('laratrust.issues.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="create_title" class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="title" id="create_title" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="create_description" class="block text-sm font-medium text-gray-700">Описание</label>
                        <textarea name="description" id="create_description" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="create_status_id" class="block text-sm font-medium text-gray-700">Статус</label>
                        <select name="status_id" id="create_status_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_id') border-red-500 @enderror" required>
                            <option value="">-- Выберите статус --</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="create_type_id" class="block text-sm font-medium text-gray-700">Тип задачи</label>
                        <select name="type_id" id="create_type_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type_id') border-red-500 @enderror" required>
                            <option value="">-- Выберите тип --</option>
                            @foreach ($issueTypes as $type)
                                <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="create_project_id" class="block text-sm font-medium text-gray-700">Проект</label>
                        <select name="project_id" id="create_project_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror" required>
                            <option value="">-- Выберите проект --</option>
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
                    <div class="mb-4">
                        <label for="create_priority_id" class="block text-sm font-medium text-gray-700">Приоритет</label>
                        <select name="priority_id" id="create_priority_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('priority_id') border-red-500 @enderror" required>
                            <option value="">-- Выберите приоритет --</option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                    {{ $priority->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
        <div x-show="openEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" x-cloak>
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Редактировать задачу</h2>
                <form method="POST" :action="'{{ route('laratrust.issues.update', '') }}/' + editId">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_title" class="block text-sm font-medium text-gray-700">Название</label>
                        <input type="text" name="title" id="edit_title" x-model="editTitle" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700">Описание</label>
                        <textarea name="description" id="edit_description" x-model="editDescription" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="edit_status_id" class="block text-sm font-medium text-gray-700">Статус</label>
                        <select name="status_id" id="edit_status_id" x-model="editStatus" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_id') border-red-500 @enderror" required>
                            <option value="">-- Выберите статус --</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('status_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="edit_type_id" class="block text-sm font-medium text-gray-700">Тип задачи</label>
                        <select name="type_id" id="edit_type_id" x-model="editTypeId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type_id') border-red-500 @enderror" required>
                            <option value="">-- Выберите тип --</option>
                            @foreach ($issueTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="edit_project_id" class="block text-sm font-medium text-gray-700">Проект</label>
                        <select name="project_id" id="edit_project_id" x-model="editProjectId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror" required>
                            <option value="">-- Выберите проект --</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="edit_priority_id" class="block text-sm font-medium text-gray-700">Приоритет</label>
                        <select name="priority_id" id="edit_priority_id" x-model="editPriorityId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('priority_id') border-red-500 @enderror" required>
                            <option value="">-- Выберите приоритет --</option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                            @endforeach
                        </select>
                        @error('priority_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
