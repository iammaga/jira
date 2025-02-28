<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class LaratrustPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasRole('admin')) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function roles()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('laratrust::panel.roles.index', compact('roles'));
    }

    public function permissions()
    {
        $permissions = Permission::paginate(10);
        return view('laratrust::panel.permissions.index', compact('permissions'));
    }

    public function rolesAssignment()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        return view('laratrust::panel.roles-assignment.index', compact('users', 'roles'));
    }
}
