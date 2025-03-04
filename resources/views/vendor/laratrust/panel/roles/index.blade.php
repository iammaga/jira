@extends('laratrust::panel.layout')

@section('title', 'Список ролей')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Роли</h1>
    </div>

    <!-- Кнопка создания и фильтры -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-4 sm:space-y-0">
        <a href="{{ route('laratrust.roles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
            Создать роль
        </a>
        <form method="GET" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Поиск по имени" class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="project_id" class="w-full sm:w-48 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Все проекты</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ $project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                Фильтровать
            </button>
        </form>
    </div>

    <!-- Форма массового удаления и таблица -->
    <form method="POST" action="{{ route('laratrust.roles.mass-destroy') }}" id="mass-delete">
        @csrf @method('DELETE')
        <div class="mb-4">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200 disabled:bg-red-300" onclick="return confirm('Удалить выбранные роли?')" id="mass-delete-btn" disabled>
                Удалить выбранные
            </button>
        </div>
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <input type="checkbox" id="select-all" class="rounded">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('laratrust.roles.index', ['sort' => 'name', 'direction' => $direction === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-blue-600">
                            Название {{ $sort === 'name' ? ($direction === 'asc' ? '↑' : '↓') : '' }}
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Проекты</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Прав</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($roles as $role)
                    <tr class="hover:bg-gray-100 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="ids[]" value="{{ $role->id }}" class="rounded">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $role->display_name ?? $role->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ optional($role->projects)->pluck('name')->implode(', ') ?? 'Нет проектов' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $role->permissions_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <a href="{{ route('laratrust.roles.show', $role) }}" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition duration-200">Просмотр</a>
                            <a href="{{ route('laratrust.roles.edit', $role) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition duration-200">Редактировать</a>
                            <form action="{{ route('laratrust.roles.destroy', $role) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition duration-200" onclick="return confirm('Удалить роль?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Ролей не найдено</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $roles->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </form>

    <script>
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="ids[]"]');
        const deleteButton = document.getElementById('mass-delete-btn');

        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateDeleteButtonState();
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateDeleteButtonState);
        });

        function updateDeleteButtonState() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            deleteButton.disabled = !anyChecked;
        }
    </script>
@endsection
