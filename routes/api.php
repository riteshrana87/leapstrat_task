<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::namespace('api')->group(function () {    
    Route::get('/users', [UserController::class, 'getUsers']);
    // Route::middleware('guest:api')->group(function () {
    //     Route::get('/users', [UserController::class, 'getUsers']);
    // });
});



