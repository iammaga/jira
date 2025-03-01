@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создать задачу</h1>
        <form action="{{ route('laratrust.issues.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Заголовок</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Статус</label>
                <select name="status" class="form-control" required>
                    <option value="open">Открыта</option>
                    <option value="in_progress">В процессе</option>
                    <option value="closed">Закрыта</option>
                </select>
            </div>
            <div class="form-group">
                <label>Назначить пользователю</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Роль</label>
                <select name="role_id" class="form-control" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>
@endsection
