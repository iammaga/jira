@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Задачи</h1>
        <a href="{{ route('laratrust.issues.create') }}" class="btn btn-primary mb-3">Создать задачу</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Статус</th>
                <th>Назначен</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($issues as $issue)
                <tr>
                    <td>{{ $issue->id }}</td>
                    <td>{{ $issue->title }}</td>
                    <td>{{ $issue->status }}</td>
                    <td>{{ $issue->user->name }}</td>
                    <td>{{ $issue->role->name }}</td>
                    <td>
                        <a href="{{ route('laratrust.issues.edit', $issue) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <form action="{{ route('laratrust.issues.delete', $issue) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить задачу?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
