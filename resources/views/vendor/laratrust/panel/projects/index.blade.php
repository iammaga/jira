@extends('laratrust::panel.layout')

@section('content')
    <h1>Проекты</h1>
    <a href="{{ route('laratrust.projects.create') }}" class="btn btn-primary">Создать проект</a>
    <table class="table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Ключ</th>
            <th>Ролей</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($projects as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->key }}</td>
                <td>{{ $project->roles_count }}</td>
                <td>
                    <a href="{{ route('laratrust.projects.show', $project) }}" class="btn btn-info">Просмотр</a>
                    <a href="{{ route('laratrust.projects.edit', $project) }}" class="btn btn-warning">Редактировать</a>
                    <form action="{{ route('laratrust.projects.delete', $project) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить проект?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $projects->links() }}
@endsection
