<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/invitations', InvitationController::class)->name('invitations');
    Route::get('/profile', ProfileController::class)->name('profile');

    Route::prefix('project/{project}')->group(function () {
        Route::middleware('project.member')->group(function () {
            Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('project.dashboard');
            Route::get('/tasks', [ProjectController::class, 'tasks'])->name('project.tasks');
            Route::get('/users', [ProjectController::class, 'users'])->name('project.users');
        });

        Route::get('/invitations', [ProjectController::class, 'invitations'])->name('project.invitations')
            ->middleware('project.admin');
    });
});

require __DIR__.'/auth.php';
