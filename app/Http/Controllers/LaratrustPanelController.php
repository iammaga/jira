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
//        $this->middleware('permission:manage-issues')->only(['issues', 'createIssue', 'storeIssue', 'editIssue', 'updateIssue', 'deleteIssue']);
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
