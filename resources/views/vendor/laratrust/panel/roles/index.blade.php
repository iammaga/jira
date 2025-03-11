@extends('laratrust::panel.layout')

@section('title', 'Список ролей')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-user-shield mr-2"></i> Роли
        </h1>
    </div>

    <form method="POST" action="{{ route('laratrust.roles.mass-destroy') }}" id="mass-delete">
        @csrf @method('DELETE')
        <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Поиск по имени"
                       class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                        formmethod="GET"
                        formaction="{{ route('laratrust.roles.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200 flex items-center justify-center"
                        title="Фильтровать">
                    <i class="fas fa-filter py-2"></i>
                </button>
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200 disabled:bg-red-300 flex items-center justify-center"
                        onclick="return confirm('Удалить выбранные роли?')"
                        id="mass-delete-btn"
                        disabled
                        title="Удалить выбранные">
                    <i class="fas fa-trash-alt py-2"></i>
                </button>
                <a href="{{ route('laratrust.roles.create') }}"
                   class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200 flex items-center justify-center"
                   title="Создать роль">
                    <i class="fas fa-plus py-2"></i>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-2 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                        <input type="checkbox" id="select-all" class="rounded">
                    </th>
                    <th class="px-2 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <i class="fas fa-id-badge mr-1"></i> Название
                    </th>
                    <th class="px-2 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                        <i class="fas fa-heading mr-1"></i> Отображаемое имя
                    </th>
                    <th class="px-2 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                        <i class="fas fa-file-alt mr-1"></i> Описание
                    </th>
                    <th class="px-2 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                        <i class="fas fa-lock mr-1"></i> Права
                    </th>
                    <th class="px-2 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32 md:w-auto">
                        <i class="fas fa-cogs mr-1"></i> Действия
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($roles as $role)
                    <tr class="hover:bg-gray-100 transition duration-150">
                        <td class="px-2 py-2 md:px-6 md:py-4 whitespace-nowrap w-12">
                            <input type="checkbox" name="ids[]" value="{{ $role->id }}" class="rounded">
                        </td>
                        <td class="px-2 py-2 md:px-6 md:py-4 whitespace-nowrap text-gray-900 text-sm">{{ $role->name }}</td>
                        <td class="px-2 py-2 md:px-6 md:py-4 whitespace-nowrap text-gray-900 text-sm hidden sm:table-cell">{{ $role->display_name ?? '-' }}</td>
                        <td class="px-2 py-2 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden sm:table-cell">{{ $role->description ?? '-' }}</td>
                        <td class="px-2 py-2 md:px-6 md:py-4 whitespace-nowrap text-gray-700 text-sm hidden sm:table-cell">
                            {{ $role->permissions->pluck('display_name')->implode(', ') ?: '-' }}
                        </td>
                        <td class="px-2 py-2 md:px-6 md:py-4 whitespace-nowrap space-x-1 md:space-x-2 flex items-center md:w-auto">
                            <a href="{{ route('laratrust.roles.show', $role) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 flex items-center"
                               title="Просмотр">
                                <i class="fas fa-eye py-2"></i>
                            </a>
                            <a href="{{ route('laratrust.roles.edit', $role) }}"
                               class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200 flex items-center"
                               title="Редактировать">
                                <i class="fas fa-edit py-2"></i>
                            </a>
                            <form action="{{ route('laratrust.roles.destroy', $role) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 flex items-center"
                                        title="Удалить"
                                        onclick="return confirm('Удалить роль?')">
                                    <i class="fas fa-trash-alt py-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-2 py-2 md:px-6 md:py-4 text-center text-gray-500 text-sm">Ролей не найдено</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            {{ $roles->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </form>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            document.querySelectorAll('input[name="ids[]"]').forEach(cb => cb.checked = this.checked);
            updateDeleteButtonState();
        });

        function updateDeleteButtonState() {
            document.getElementById('mass-delete-btn').disabled = !document.querySelector('input[name="ids[]"]:checked');
        }
    </script>
@endsection
