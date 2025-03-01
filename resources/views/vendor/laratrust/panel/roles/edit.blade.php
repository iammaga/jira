@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Редактировать роль</h1>
        <form action="{{ route('laratrust.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" value="{{ $role->name }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Отображаемое имя</label>
                <input type="text" name="display_name" value="{{ $role->display_name }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control">{{ $role->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Обновить</button>
        </form>
    </div>
@endsection
