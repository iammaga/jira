<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class LaratrustPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-issues')->only(['issues', 'createIssue', 'storeIssue', 'editIssue', 'updateIssue', 'deleteIssue']);
        $this->middleware('permission:manage-users')->only(['roles', 'createRole', 'storeRole', 'editRole', 'updateRole', 'deleteRole', 'permissions', 'createPermission', 'storePermission', 'editPermission', 'updatePermission', 'deletePermission', 'rolesAssignment', 'assignRoles']);
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasRole('admin')) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function issues()
    {
        $issues = Issue::with('user', 'role')->get();
        return view('vendor.laratrust.panel.issues', compact('issues'));
    }

    public function createIssue()
    {
        $users = User::all();
        $roles = Role::all();
        return view('vendor.laratrust.panel.issues-create', compact('users', 'roles'));
    }

    public function storeIssue(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,in_progress,closed',
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        Issue::create($request->all());
        return redirect()->route('laratrust.issues')->with('success', 'Задача создана.');
    }

    public function editIssue(Issue $issue)
    {
        $users = User::all();
        $roles = Role::all();
        return view('vendor.laratrust.panel.issues-edit', compact('issue', 'users', 'roles'));
    }

    public function updateIssue(Request $request, Issue $issue)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,in_progress,closed',
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $issue->update($request->all());
        return redirect()->route('laratrust.issues')->with('success', 'Задача обновлена.');
    }

    public function deleteIssue(Issue $issue)
    {
        $issue->delete();
        return redirect()->route('laratrust.issues')->with('success', 'Задача удалена.');
    }

    public function roles()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('laratrust::panel.roles.index', compact('roles'));
    }

    public function createRole()
    {
        return view('vendor.laratrust.panel.roles-create');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Role::create($request->all());
        return redirect()->route('laratrust.roles')->with('success', 'Роль создана');
    }

    public function editRole(Role $role)
    {
        return view('vendor.laratrust.panel.roles-edit', compact('role'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $role->update($request->all());
        return redirect()->route('laratrust.roles')->with('success', 'Роль обновлена');
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        return redirect()->route('laratrust.roles')->with('success', 'Роль удалена');
    }

    public function permissions()
    {
        $permissions = Permission::paginate(10);
        return view('laratrust::panel.permissions.index', compact('permissions'));
    }

    public function createPermission()
    {
        return view('vendor.laratrust.panel.permissions-create');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Permission::create($request->all());
        return redirect()->route('laratrust.permissions')->with('success', 'Право создано');
    }

    public function editPermission(Permission $permission)
    {
        return view('vendor.laratrust.panel.permissions-edit', compact('permission'));
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $permission->update($request->all());
        return redirect()->route('laratrust.permissions')->with('success', 'Право обновлено');
    }

    public function deletePermission(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('laratrust.permissions')->with('success', 'Право удалено');
    }

    public function rolesAssignment()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        return view('laratrust::panel.roles-assignment.index', compact('users', 'roles'));
    }

    public function assignRoles(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::find($request->user_id);
        $user->roles()->sync($request->roles ?? []);
        return redirect()->route('laratrust.roles-assignment')->with('success', 'Роли назначены');
    }
}
