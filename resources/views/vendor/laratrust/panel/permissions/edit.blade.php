@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Редактировать право</h1>
        <form action="{{ route('laratrust.permissions.update', $permission) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" value="{{ $permission->name }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Отображаемое имя</label>
                <input type="text" name="display_name" value="{{ $permission->display_name }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control">{{ $permission->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Обновить</button>
        </form>
    </div>
@endsection
