@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать задачу</h1>
        <form action="{{ route('laratrust.issues.update', $issue) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Заголовок</label>
                <input type="text" name="title" class="form-control" value="{{ $issue->title }}" required>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control">{{ $issue->description }}</textarea>
            </div>
            <div class="form-group">
                <label>Статус</label>
                <select name="status" class="form-control" required>
                    <option value="open" {{ $issue->status == 'open' ? 'selected' : '' }}>Открыта</option>
                    <option value="in_progress" {{ $issue->status == 'in_progress' ? 'selected' : '' }}>В процессе</option>
                    <option value="closed" {{ $issue->status == 'closed' ? 'selected' : '' }}>Закрыта</option>
                </select>
            </div>
            <div class="form-group">
                <label>Назначить пользователю</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $issue->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Роль</label>
                <select name="role_id" class="form-control" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $issue->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Обновить</button>
        </form>
    </div>
@endsection
