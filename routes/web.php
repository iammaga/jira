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
    Route::get('/roles', [LaratrustPanelController::class, 'roles'])->name('laratrust.roles.index');
    Route::get('/permissions', [LaratrustPanelController::class, 'permissions'])->name('laratrust.permissions.index');
    Route::get('/roles-assignment', [LaratrustPanelController::class, 'rolesAssignment'])->name('laratrust.roles-assignment.index');

    Route::get('/issues', [LaratrustPanelController::class, 'issues'])->name('laratrust.issues');
    Route::get('/issues/create', [LaratrustPanelController::class, 'createIssue'])->name('laratrust.issues.create');
    Route::post('/issues', [LaratrustPanelController::class, 'storeIssue'])->name('laratrust.issues.store');
    Route::get('/issues/{issue}/edit', [LaratrustPanelController::class, 'editIssue'])->name('laratrust.issues.edit');
    Route::put('/issues/{issue}', [LaratrustPanelController::class, 'updateIssue'])->name('laratrust.issues.update');
    Route::delete('/issues/{issue}', [LaratrustPanelController::class, 'deleteIssue'])->name('laratrust.issues.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
