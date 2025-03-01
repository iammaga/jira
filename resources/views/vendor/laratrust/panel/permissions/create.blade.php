@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Создать право</h1>
        <form action="{{ route('laratrust.permissions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Отображаемое имя</label>
                <input type="text" name="display_name" class="form-control">
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>
@endsection
