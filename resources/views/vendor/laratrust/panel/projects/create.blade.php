@extends('laratrust::panel.layout')

@section('content')
    <h1>Создать проект</h1>
    <form method="POST" action="{{ route('laratrust.projects.store') }}">
        @csrf
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Ключ</label>
            <input type="text" name="key" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Описание</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Создать</button>
    </form>
@endsection
