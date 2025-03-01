<?php

use App\Http\Controllers\LaratrustPanelController;
use App\Http\Controllers\ProfileController;
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

Route::middleware(['web', 'auth'])->prefix('laratrust')->group(function () {
    Route::get('/issues', [LaratrustPanelController::class, 'issues'])->name('laratrust.issues');
    Route::get('/issues/create', [LaratrustPanelController::class, 'createIssue'])->name('laratrust.issues.create');
    Route::post('/issues', [LaratrustPanelController::class, 'storeIssue'])->name('laratrust.issues.store');
    Route::get('/issues/{issue}/edit', [LaratrustPanelController::class, 'editIssue'])->name('laratrust.issues.edit');
    Route::put('/issues/{issue}', [LaratrustPanelController::class, 'updateIssue'])->name('laratrust.issues.update');
    Route::delete('/issues/{issue}', [LaratrustPanelController::class, 'deleteIssue'])->name('laratrust.issues.delete');

    Route::get('/roles', [LaratrustPanelController::class, 'roles'])->name('laratrust.roles');
    Route::get('/roles/create', [LaratrustPanelController::class, 'createRole'])->name('laratrust.roles.create');
    Route::post('/roles', [LaratrustPanelController::class, 'storeRole'])->name('laratrust.roles.store');
    Route::get('/roles/{role}/edit', [LaratrustPanelController::class, 'editRole'])->name('laratrust.roles.edit');
    Route::put('/roles/{role}', [LaratrustPanelController::class, 'updateRole'])->name('laratrust.roles.update');
    Route::delete('/roles/{role}', [LaratrustPanelController::class, 'deleteRole'])->name('laratrust.roles.delete');

    Route::get('/permissions', [LaratrustPanelController::class, 'permissions'])->name('laratrust.permissions');
    Route::get('/permissions/create', [LaratrustPanelController::class, 'createPermission'])->name('laratrust.permissions.create');
    Route::post('/permissions', [LaratrustPanelController::class, 'storePermission'])->name('laratrust.permissions.store');
    Route::get('/permissions/{permission}/edit', [LaratrustPanelController::class, 'editPermission'])->name('laratrust.permissions.edit');
    Route::put('/permissions/{permission}', [LaratrustPanelController::class, 'updatePermission'])->name('laratrust.permissions.update');
    Route::delete('/permissions/{permission}', [LaratrustPanelController::class, 'deletePermission'])->name('laratrust.permissions.delete');

    Route::get('/roles-assignment', [LaratrustPanelController::class, 'rolesAssignment'])->name('laratrust.roles-assignment');
    Route::post('/roles-assignment', [LaratrustPanelController::class, 'assignRoles'])->name('laratrust.roles-assignment.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
