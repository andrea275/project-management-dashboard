<?php

use App\Http\Controllers\API\PriorityController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\TaskController;
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

Route::get('status', [StatusController::class, 'index']);
Route::get('priority', [PriorityController::class, 'index']);
Route::apiResource('project', ProjectController::class);
Route::apiResource('project/{project}/task', TaskController::class);
