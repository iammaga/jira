<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    // Главная страница админ-панели
    public function index()
    {
        return view('admin.dashboard', [
            'users' => User::all(),
            'roles' => Role::all()
        ]);
    }

    public function assignRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $role = Role::where('name', $request->role)->first();

        if ($role) {
            $user->attachRole($role);
            return redirect()->back()->with('success', 'Роль успешно назначена.');
        }

        return redirect()->back()->with('error', 'Роль не найдена.');
    }
}
