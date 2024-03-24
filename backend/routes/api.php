<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\v1\CompleteTaskController;
use App\Http\Controllers\v1\TaskController;
use App\Http\Controllers\v2\CompleteTaskController as V2CompleteTaskController;
use App\Http\Controllers\v2\TaskController as V2TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
Route::post('/register', RegisterController::class);

Route::prefix('v1')->group(function(){
    Route::apiResource('/task', TaskController::class);
    Route::patch('/task/{task}/completed', CompleteTaskController::class);
});

Route::middleware('auth:sanctum')->prefix('v2')->group(function(){
    Route::apiResource('/task', V2TaskController::class);
    Route::patch('/task/{task}/completed', V2CompleteTaskController::class);
});