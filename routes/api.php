<?php

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
    Route::get('status', [StatusController::class, 'index']);
    Route::get('project/{project}/status-with-task-count', [StatusController::class, 'statusWithTaskCount']);

    Route::get('priority', [PriorityController::class, 'index']);

    Route::apiResource('project', ProjectController::class);
    Route::apiResource('project/{project}/task', TaskController::class);

    Route::prefix('project/{project}/user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
        Route::post('/invite', [UserController::class, 'invite']);
        Route::get('/accept-invitation', [UserController::class, 'acceptInvitation']);
    });

    Route::post('task/{task}/comment', [CommentController::class, 'store']);
    Route::delete('task/{task}/comment/{comment}', [CommentController::class, 'destroy']);
});
