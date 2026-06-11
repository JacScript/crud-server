<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('v1/students', [StudentController::class, 'index']);
Route::post('v1/students', [StudentController::class,'store']);
Route::get('v1/students/{id}', [StudentController::class,'show']);
Route::put('v1/students/{id}', [StudentController::class,'update']);
Route::delete('v1/students/{id}', [StudentController::class,'destroy']);