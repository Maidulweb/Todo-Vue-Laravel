<?php

use App\Http\Controllers\v2\CompleteTaskController;
use App\Http\Controllers\v2\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function(){
    Route::apiResource('/task', TaskController::class);
    Route::patch('/task/{task}/completed', CompleteTaskController::class);
});