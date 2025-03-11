<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\IssueType;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Release;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Sprint;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LaratrustPanelController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:manage-issues')->only(['issues', 'createIssue', 'storeIssue', 'editIssue', 'updateIssue', 'deleteIssue']);
//        $this->middleware('permission:manage-users')->only(['roles', 'createRole', 'storeRole', 'editRole', 'updateRole', 'deleteRole', 'permissions', 'createPermission', 'storePermission', 'editPermission', 'updatePermission', 'deletePermission', 'rolesAssignment', 'assignRoles']);
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
        $issues = Issue::with(['status', 'project', 'type', 'priority', 'sprint', 'release', 'assignee', 'createdBy'])
            ->simplePaginate(10);
        $users = User::all(['id', 'name']);
        $roles = Role::all(['id', 'display_name', 'name']);
        $projects = Project::all(['id', 'name']);
        $issueTypes = IssueType::all(['id', 'name']);
        $priorities = Priority::all(['id', 'name']);
        $statuses = Status::all(['id', 'name']);
        $sprints = Sprint::all(['id', 'name']);
        $releases = Release::all(['id', 'version']); // Используем 'version' вместо 'name'

        return view('laratrust::panel.issues.index', compact('issues', 'users', 'roles', 'projects', 'issueTypes', 'priorities', 'statuses', 'sprints', 'releases'));
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
            'status_id' => 'required|exists:statuses,id',
            'project_id' => 'nullable|exists:projects,id',
            'type_id' => 'required|exists:issue_types,id',
            'priority_id' => 'required|exists:priorities,id',
            'sprint_id' => 'nullable|exists:sprints,id', // Валидация для sprint_id
            'release_id' => 'nullable|exists:releases,id', // Валидация для release_id
            'assignee_id' => 'nullable|exists:users,id', // Валидация для assignee_id
        ]);

        Issue::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status_id' => $request->input('status_id'),
            'project_id' => $request->input('project_id'),
            'type_id' => $request->input('type_id'),
            'priority_id' => $request->input('priority_id'),
            'sprint_id' => $request->input('sprint_id'), // Сохранение sprint_id
            'release_id' => $request->input('release_id'), // Сохранение release_id
            'assignee_id' => $request->input('assignee_id'), // Сохранение assignee_id
            'created_by' => auth()->check() ? auth()->id() : null,
        ]);

        return redirect()->route('laratrust.issues')->with('success', 'Задача создана.');
    }

    public function editIssue(Issue $issue)
    {
        $users = User::all();
        $roles = Role::all();
        $projects = Project::all(['id', 'name']);
        $issueTypes = IssueType::all(['id', 'name']);
        $priorities = Priority::all(['id', 'name']);
        $statuses = Status::all(['id', 'name']);

        return view('vendor.laratrust.panel.issues-edit', compact('issue', 'users', 'roles', 'projects', 'issueTypes', 'priorities', 'statuses'));
    }

    public function updateIssue(Request $request, Issue $issue)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:statuses,id',
            'project_id' => 'nullable|exists:projects,id',
            'type_id' => 'required|exists:issue_types,id',
            'priority_id' => 'required|exists:priorities,id',
            'sprint_id' => 'nullable|exists:sprints,id', // Валидация для sprint_id
            'release_id' => 'nullable|exists:releases,id', // Валидация для release_id
            'assignee_id' => 'nullable|exists:users,id', // Валидация для assignee_id
        ]);

        $issue->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status_id' => $request->input('status_id'),
            'project_id' => $request->input('project_id'),
            'type_id' => $request->input('type_id'),
            'priority_id' => $request->input('priority_id'),
            'sprint_id' => $request->input('sprint_id'), // Обновление sprint_id
            'release_id' => $request->input('release_id'), // Обновление release_id
            'assignee_id' => $request->input('assignee_id'), // Обновление assignee_id
        ]);

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

    public function permissions(Request $request)
    {
        $permissions = Permission::simplePaginate(10);
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
        Session::flash('laratrust-success', 'Разрешение успешно создано');
        return redirect()->route('laratrust.permissions.index');
    }

    public function editPermission(Permission $permission)
    {
        return view('vendor.laratrust.panel.permissions-edit', compact('permission'));
    }

    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $permission->update($request->all());
        Session::flash('laratrust-success', 'Разрешение успешно обновлено');
        return redirect()->route('laratrust.permissions.index');
    }

    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        Session::flash('laratrust-success', 'Разрешение успешно удалено');
        return redirect()->route('laratrust.permissions.index');
    }

    public function rolesAssignment()
    {
        $users = User::with(['roles', 'permissions'])->paginate(10);
        $roles = Role::all();
        $permissions = Permission::all();

        return view('laratrust::panel.roles-assignment.index', compact('users', 'roles', 'permissions'));
    }

    public function assignRoles(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $user->roles()->sync($request->roles ?? []);

        if ($request->permissions) {
            $user->permissions()->sync($request->permissions);
        } else {
            $user->permissions()->detach();
        }

        return redirect()->back()->with('success', 'Роли и разрешения назначены');
    }

    public function showRolesAssignment($userId)
    {
        $user = User::findOrFail($userId);
        return view('laratrust::panel.roles-assignment.show', compact('user'));
    }

    public function editRolesAssignment($userId)
    {
        $user = User::findOrFail($userId);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('laratrust::panel.roles-assignment.edit', compact('user', 'roles', 'permissions'));
    }

    public function updateRolesAssignment(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->sync($request->roles ?? []);
        $user->permissions()->sync($request->permissions ?? []);

        return redirect()->route('laratrust.roles-assignment.index')->with('success', 'Роли и разрешения успешно обновлены');
    }

    public function removeRoles(User $user)
    {
        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        return redirect()->route('laratrust.roles-assignment.index')->with('success', 'Роли успешно отозваны');
    }

    public function projects()
    {
        $projects = Project::withCount('roles')->simplePaginate(10);
        return view('laratrust::panel.projects.index', compact('projects'));
    }

    public function createProject()
    {
        return view('laratrust.panel.projects.create');
    }

    public function storeProject(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:projects,name',
            'key' => 'required|string|max:10|unique:projects,key',
            'description' => 'nullable|string',
        ]);

        Project::create($data);
        Session::flash('laratrust-success', 'Проект успешно создан');
        return redirect()->route('laratrust.projects');
    }

    public function showProject(Project $project)
    {
        $project->load('roles.permissions');
        return view('laratrust::panel.projects.show', compact('project'));
    }

    public function editProject(Project $project)
    {
        return view('laratrust::panel.projects.edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:projects,name,' . $project->id,
            'key' => 'required|string|max:10|unique:projects,key,' . $project->id,
            'description' => 'nullable|string',
        ]);

        $project->update($data);
        Session::flash('laratrust-success', 'Проект успешно обновлен');
        return redirect()->route('laratrust.projects');
    }

    public function deleteProject(Project $project)
    {
        $project->delete();
        Session::flash('laratrust-success', 'Проект успешно удален');
        return redirect()->route('laratrust.projects');
    }


}
