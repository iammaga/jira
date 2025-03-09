@extends('laratrust::panel.layout')

@section('title', 'Список задач')

@section('content')
    <div x-data="{ openCreateModal: false, openEditModal: false, editId: null, editTitle: '', editDescription: '', editStatus: '', editProjectId: '', editTypeId: '', editPriorityId: '', editSprintId: '', editReleaseId: '', editAssigneeId: ''}">
        <!-- Заголовок -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                Задачи
            </h1>
            <!-- Кнопка создания -->
            <button @click="openCreateModal = true" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200 flex items-center" title="Создать задачу">
                <i class="fas fa-plus md:mr-0 py-2"></i>
            </button>
        </div>

        <!-- Таблица задач -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-id-badge mr-1"></i> ID
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-heading mr-1"></i> Название
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-file-alt mr-1"></i> Описание
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-info-circle mr-1"></i> Статус
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-project-diagram mr-1"></i> Проект
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-tasks mr-1"></i> Тип
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Приоритет
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-running mr-1"></i> Спринт
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-box-open mr-1"></i> Релиз
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-user-check mr-1"></i> Исполнитель
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-user-alt mr-1"></i> Автор
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        <i class="fas fa-calendar-alt mr-1"></i> Создано
                    </th>
                    <th class="px-4 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-cogs mr-1"></i> Действия
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($issues as $issue)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-900 text-sm">{{ $issue->id }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-900 text-sm">{{ $issue->title }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->description ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->status->name ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->project->name ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->type->name ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->priority->name ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->sprint->name ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->release->version ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->assignee->name ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->createdBy->name ?? 'Не указано' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden md:table-cell">{{ $issue->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 whitespace-nowrap space-x-2 flex items-center">
                            <button @click="editId = {{ $issue->id }}; editTitle = '{{ $issue->title }}'; editDescription = '{{ $issue->description ?? '' }}'; editStatus = '{{ $issue->status_id }}'; editProjectId = '{{ $issue->project_id }}'; editTypeId = '{{ $issue->type_id }}'; editPriorityId = '{{ $issue->priority_id }}'; editSprintId = '{{ $issue->sprint_id }}'; editReleaseId = '{{ $issue->release_id }}'; editAssigneeId = '{{ $issue->assignee_id }}'; openEditModal = true"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200 flex items-center" title="Редактировать">
                                <i class="fas fa-edit md:mr-0 py-2"></i>
                            </button>
                            <form action="{{ route('laratrust.issues.delete', $issue) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 flex items-center" title="Удалить" onclick="return confirm('Удалить задачу?')">
                                    <i class="fas fa-trash-alt md:mr-0 py-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="px-4 py-3 md:px-6 md:py-4 text-center text-gray-500 text-sm">Задачи не найдены</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-6 flex justify-center">
                {{ $issues->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Модальное окно для создания -->
        <div x-show="openCreateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" x-cloak>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
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
                        <select name="project_id" id="create_project_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror">
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
                    <div class="mb-4">
                        <label for="create_sprint_id" class="block text-sm font-medium text-gray-700">Спринт</label>
                        <select name="sprint_id" id="create_sprint_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sprint_id') border-red-500 @enderror">
                            <option value="">-- Выберите спринт --</option>
                            @foreach ($sprints as $sprint)
                                <option value="{{ $sprint->id }}" {{ old('sprint_id') == $sprint->id ? 'selected' : '' }}>
                                    {{ $sprint->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sprint_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="create_release_id" class="block text-sm font-medium text-gray-700">Релиз</label>
                        <select name="release_id" id="create_release_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('release_id') border-red-500 @enderror">
                            <option value="">-- Выберите релиз --</option>
                            @foreach ($releases as $release)
                                <option value="{{ $release->id }}" {{ old('release_id') == $release->id ? 'selected' : '' }}>
                                    {{ $release->version }}
                                </option>
                            @endforeach
                        </select>
                        @error('release_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="create_assignee_id" class="block text-sm font-medium text-gray-700">Исполнитель</label>
                        <select name="assignee_id" id="create_assignee_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('assignee_id') border-red-500 @enderror">
                            <option value="">-- Выберите исполнителя --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('assignee_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('assignee_id')
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
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
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
                        <select name="project_id" id="edit_project_id" x-model="editProjectId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror">
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
                    <div class="mb-4">
                        <label for="edit_sprint_id" class="block text-sm font-medium text-gray-700">Спринт</label>
                        <select name="sprint_id" id="edit_sprint_id" x-model="editSprintId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sprint_id') border-red-500 @enderror">
                            <option value="">-- Выберите спринт --</option>
                            @foreach ($sprints as $sprint)
                                <option value="{{ $sprint->id }}">{{ $sprint->name }}</option>
                            @endforeach
                        </select>
                        @error('sprint_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="edit_release_id" class="block text-sm font-medium text-gray-700">Релиз</label>
                        <select name="release_id" id="edit_release_id" x-model="editReleaseId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('release_id') border-red-500 @enderror">
                            <option value="">-- Выберите релиз --</option>
                            @foreach ($releases as $release)
                                <option value="{{ $release->id }}">{{ $release->version }}</option>
                            @endforeach
                        </select>
                        @error('release_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="edit_assignee_id" class="block text-sm font-medium text-gray-700">Исполнитель</label>
                        <select name="assignee_id" id="edit_assignee_id" x-model="editAssigneeId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('assignee_id') border-red-500 @enderror">
                            <option value="">-- Выберите исполнителя --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assignee_id')
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
