@extends('laratrust::panel.layout')

@section('content')
    <h1>Редактировать проект: {{ $project->name }}</h1>
    <form method="POST" action="{{ route('laratrust.projects.update', $project) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="name" value="{{ $project->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Ключ</label>
            <input type="text" name="key" value="{{ $project->key }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Описание</label>
            <textarea name="description" class="form-control">{{ $project->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
@endsection
