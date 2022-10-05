<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');

    Route::prefix('project/{project}')->group(function () {
        Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('project.dashboard');
        Route::get('/tasks', [ProjectController::class, 'tasks'])->name('project.tasks');
        Route::get('/users', [ProjectController::class, 'users'])->name('project.users');
    });
});

require __DIR__.'/auth.php';
