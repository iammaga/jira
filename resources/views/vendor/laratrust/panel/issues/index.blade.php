@extends('laratrust::panel.layout')

@section('title', 'Список задач')

@section('content')
    <div x-data="issuesCrud">
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($issues as $issue)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $issue->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $issue->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $issue->description ?? 'Не указано' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ ucfirst($issue->status->name) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <button @click="editIssue({{ $issue->id }}, '{{ $issue->title }}', '{{ $issue->description }}', '{{ $issue->status }}', {{ $issue->user_id ?? 'null' }}, {{ $issue->role_id ?? 'null' }})"
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
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Задачи не найдены</td>
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
                        <label for="create_status" class="block text-sm font-medium text-gray-700">Статус</label>
                        <select name="status" id="create_status" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                            @foreach ($issues as $issue)
                            <option value="{{ $issue->status }}" {{ old('status', $issue->status) == $issue->status ? 'selected' : '' }}>
                                {{ ucfirst($issue->status->name) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{--                    <div class="mb-4">--}}
{{--                        <label for="create_user_id" class="block text-sm font-medium text-gray-700">Пользователь</label>--}}
{{--                        <select name="user_id" id="create_user_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror" required>--}}
{{--                            <option value="">-- Выберите пользователя --</option>--}}
{{--                            @foreach ($users as $user)--}}
{{--                                <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @error('user_id')--}}
{{--                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="mb-4">--}}
{{--                        <label for="create_role_id" class="block text-sm font-medium text-gray-700">Роль</label>--}}
{{--                        <select name="role_id" id="create_role_id" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role_id') border-red-500 @enderror" required>--}}
{{--                            <option value="">-- Выберите роль --</option>--}}
{{--                            @foreach ($roles as $role)--}}
{{--                                <option value="{{ $role->id }}">{{ $role->display_name ?? $role->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @error('role_id')--}}
{{--                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
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
                <form method="POST" x-bind:action="'{{ route('laratrust.issues.update', '') }}/' + editId">
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
                        <label for="edit_status" class="block text-sm font-medium text-gray-700">Статус</label>
                        <select name="status" id="edit_status" x-model="editStatus" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                            @foreach ($issues as $issue)
                                <option value="{{ $issue->status }}" {{ old('status', $issue->status) == $issue->status ? 'selected' : '' }}>
                                    {{ ucfirst($issue->status->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
{{--                    <div class="mb-4">--}}
{{--                        <label for="edit_user_id" class="block text-sm font-medium text-gray-700">Пользователь</label>--}}
{{--                        <select name="user_id" id="edit_user_id" x-model="editUserId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror" required>--}}
{{--                            <option value="">-- Выберите пользователя --</option>--}}
{{--                            @foreach ($users as $user)--}}
{{--                                <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @error('user_id')--}}
{{--                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="mb-4">--}}
{{--                        <label for="edit_role_id" class="block text-sm font-medium text-gray-700">Роль</label>--}}
{{--                        <select name="role_id" id="edit_role_id" x-model="editRoleId" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role_id') border-red-500 @enderror" required>--}}
{{--                            <option value="">-- Выберите роль --</option>--}}
{{--                            @foreach ($roles as $role)--}}
{{--                                <option value="{{ $role->id }}">{{ $role->display_name ?? $role->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @error('role_id')--}}
{{--                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const issueCrud = {
                openCreateModal: false,
                openEditModal: false,
                editId: null,
                editTitle: '',
                editDescription: '',
                editStatus: '',
                editUserId: null,
                editRoleId: null,
                editIssue(id, title, description, status) {
                    this.openEditModal = true;
                    this.editId = id;
                    this.editTitle = title;
                    this.editDescription = description;
                    this.editStatus = status;
                    // this.editUserId = user_id;
                    // this.editRoleId = role_id;
                }
            };
            window.issuesCrud = issueCrud;
        });
    </script>
@endsection

<style>
    [x-cloak] { display: none !important; }
</style>
