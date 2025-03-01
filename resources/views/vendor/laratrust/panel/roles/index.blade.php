@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Роли</h1>
        <a href="{{ route('laratrust.roles.create') }}" class="btn btn-primary mb-3">Создать роль</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Отображаемое имя</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>
                        <a href="{{ route('laratrust.roles.edit', $role) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <form action="{{ route('laratrust.roles.delete', $role) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить роль?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
