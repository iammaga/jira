@extends('laratrust::panel.layout')

@section('content')
    <h1>Проект: {{ $project->name }}</h1>
    <p><strong>Ключ:</strong> {{ $project->key }}</p>
    <p><strong>Описание:</strong> {{ $project->description }}</p>
    <h3>Роли в проекте</h3>
    <ul>
        @foreach ($project->roles as $role)
            <li>{{ $role->display_name ?? $role->name }} (Прав: {{ $role->permissions->count() }})</li>
        @endforeach
    </ul>
    <a href="{{ route('laratrust.projects.edit', $project) }}" class="btn btn-warning">Редактировать</a>
@endsection
