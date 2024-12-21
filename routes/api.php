<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);

Route::post('/register', [App\Http\Controllers\LoginController::class, 'register'] );
Route::match(["get", "post"], '/logout', [App\Http\Controllers\LoginController::class, 'logout'])->middleware('auth:web');
Route::get("logged-in", [App\Http\Controllers\LoginController::class, 'loggedIn'])->middleware("auth:sanctum");
Route::post("/confirm-email-verify", [App\Http\Controllers\LoginController::class, 'confirmEmailVerify'])->middleware("auth:sanctum");
