<?php

use App\Http\Controllers\API\InvitationController as UserInvitationController;
use App\Http\Controllers\API\UserController as AuthUserController;
use App\Http\Controllers\API\Project\InvitationController;
use App\Http\Controllers\API\Project\PriorityController;
use App\Http\Controllers\API\Project\CommentController;
use App\Http\Controllers\API\Project\ProjectController;
use App\Http\Controllers\API\Project\StatusController;
use App\Http\Controllers\API\Project\TaskController;
use App\Http\Controllers\API\Project\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthUserController::class, 'getAuth']);
    Route::put('/user/profile', [AuthUserController::class, 'updateProfile']);
    Route::put('/user/password', [AuthUserController::class, 'updatePassword']);

    Route::get('status', [StatusController::class, 'index']);

    Route::apiResource('project', ProjectController::class);

    Route::prefix('project/{project}')->group(function () {
        Route::middleware('project.member')->group(function () {
            Route::get('status-with-task-count', [StatusController::class, 'statusWithTaskCount']);

            Route::apiResource('task', TaskController::class);
            Route::put('task/{task}/status', [TaskController::class, 'updateStatus']);

            Route::get('/user', [UserController::class, 'index']);
            Route::get('/user-is-admin', [UserController::class, 'isADmin']);
        });

        Route::middleware('project.admin')->group(function () {
            Route::apiResource('invitation', InvitationController::class)->except(['show', 'destroy']);
            Route::get('invitation/{invitation}/resend', [InvitationController::class, 'resend']);

            Route::prefix('user')->group(function () {
                Route::put('/{user}', [UserController::class, 'update']);
                Route::delete('/{user}', [UserController::class, 'destroy']);
            });
        });
    });

    Route::get('priority', [PriorityController::class, 'index']);

    Route::prefix('invitation')->group(function () {
        Route::get('/', [UserInvitationController::class, 'index']);
        Route::delete('{invitation}', [UserInvitationController::class, 'destroy']);
        Route::get('{invitation}/accept', [UserInvitationController::class, 'accept']);
    });

    Route::prefix('task/{task}/comment')->group(function () {
        Route::post('/', [CommentController::class, 'store']);
        Route::delete('/{comment}', [CommentController::class, 'destroy']);
    });
});
