@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Права</h1>
        <a href="{{ route('laratrust.permissions.create') }}" class="btn btn-primary mb-3">Создать право</a>
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
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->display_name }}</td>
                    <td>{{ $permission->description }}</td>
                    <td>
                        <a href="{{ route('laratrust.permissions.edit', $permission) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <form action="{{ route('laratrust.permissions.delete', $permission) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить право?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
