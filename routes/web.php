<?php

use App\Http\Controllers\LaratrustPanelController;
use App\Http\Controllers\ProfileController;
use Laratrust\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'laratrust', 'as' => 'laratrust.'], function () {
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
});

Route::middleware(['web', 'auth'])->prefix('laratrust')->name('laratrust.')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/issues', [LaratrustPanelController::class, 'issues'])->name('issues');
        Route::get('/issues/create', [LaratrustPanelController::class, 'createIssue'])->name('issues.create');
        Route::post('/issues', [LaratrustPanelController::class, 'storeIssue'])->name('issues.store');
        Route::get('/issues/{issue}/edit', [LaratrustPanelController::class, 'editIssue'])->name('issues.edit');
        Route::put('/issues/{issue}', [LaratrustPanelController::class, 'updateIssue'])->name('issues.update');
        Route::delete('/issues/{issue}', [LaratrustPanelController::class, 'deleteIssue'])->name('issues.delete');

        Route::resource('roles', RolesController::class)->except(['create', 'store']);
        Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
        Route::delete('/roles/mass-destroy', [RolesController::class, 'destroy'])->name('roles.mass-destroy');

        Route::get('/permissions', [LaratrustPanelController::class, 'permissions'])->name('permissions.index');
        Route::get('/permissions/create', [LaratrustPanelController::class, 'createPermission'])->name('permissions.create');
        Route::post('/permissions', [LaratrustPanelController::class, 'storePermission'])->name('permissions.store');
        Route::get('/permissions/{permission}/edit', [LaratrustPanelController::class, 'editPermission'])->name('permissions.edit');
        Route::put('/permissions/{permission}', [LaratrustPanelController::class, 'updatePermission'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [LaratrustPanelController::class, 'deletePermission'])->name('permissions.delete');
    });

    Route::middleware('role:admin|manager')->group(function () {
        Route::get('/roles-assignment', [LaratrustPanelController::class, 'rolesAssignment'])->name('roles-assignment.index');
        Route::post('/roles-assignment', [LaratrustPanelController::class, 'assignRoles'])->name('roles-assignment.store');
        Route::delete('/roles-assignment/revoke/{user}', [LaratrustPanelController::class, 'revokeRoles'])->name('roles-assignment.revoke');
        Route::get('/roles-assignment/{user}', [LaratrustPanelController::class, 'showRolesAssignment'])->name('roles-assignment.show');
        Route::get('/roles-assignment/{user}/edit', [LaratrustPanelController::class, 'editRolesAssignment'])->name('roles-assignment.edit');
        Route::put('/roles-assignment/{user}', [LaratrustPanelController::class, 'updateRolesAssignment'])->name('roles-assignment.update');
    });

    Route::middleware('role:admin|manager|user')->group(function () {
        Route::get('/projects', [LaratrustPanelController::class, 'projects'])->name('projects');
        Route::get('/projects/create', [LaratrustPanelController::class, 'createProject'])->name('projects.create');
        Route::post('/projects', [LaratrustPanelController::class, 'storeProject'])->name('projects.store');
        Route::get('/projects/{project}', [LaratrustPanelController::class, 'showProject'])->name('projects.show');
        Route::get('/projects/{project}/edit', [LaratrustPanelController::class, 'editProject'])->name('projects.edit');
        Route::put('/projects/{project}', [LaratrustPanelController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{project}', [LaratrustPanelController::class, 'deleteProject'])->name('projects.delete');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
