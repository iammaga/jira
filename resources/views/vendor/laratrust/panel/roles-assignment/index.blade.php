@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Назначение ролей</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('laratrust.roles-assignment.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Выберите пользователя</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Роли</label>
                @foreach ($roles as $role)
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input">
                        <label class="form-check-label">{{ $role->name }}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Назначить</button>
        </form>

        <h2 class="mt-5">Текущие назначения</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Пользователь</th>
                <th>Роли</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }} ({{ $user->email }})</td>
                    <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
