@extends('laratrust::panel.layout')

@section('title', 'Редактирование ролей')

@section('content')
    <div class="max-w-full mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Редактирование ролей: {{ $user->name }}</h1>

        <form method="POST" action="{{ route('laratrust.roles-assignment.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Роли</label>
                <button type="button" id="select-all-roles" class="text-blue-500 text-sm mb-2">Выбрать все</button>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($roles as $role)
                        <div class="flex items-center bg-gray-100 p-4 rounded-md shadow-sm">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role-{{ $role->id }}"
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 role-checkbox"
                                   @if($user->roles->contains($role)) checked @endif>
                            <label for="role-{{ $role->id }}" class="ml-2 text-sm text-gray-700">{{ $role->display_name ?? $role->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Разрешения</label>
                <button type="button" id="select-all-permissions" class="text-blue-500 text-sm mb-2">Выбрать все</button>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($permissions as $permission)
                        <div class="flex items-center bg-gray-100 p-4 rounded-md shadow-sm">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}"
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 permission-checkbox"
                                   @if($user->permissions->contains($permission)) checked @endif>
                            <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-700">{{ $permission->display_name ?? $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('laratrust.roles-assignment.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                    Назад
                </a>
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition duration-200">Обновить</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('select-all-roles').addEventListener('click', function () {
            document.querySelectorAll('.role-checkbox').forEach(checkbox => checkbox.checked = true);
        });
        document.getElementById('select-all-permissions').addEventListener('click', function () {
            document.querySelectorAll('.permission-checkbox').forEach(checkbox => checkbox.checked = true);
        });
    </script>
@endsection
