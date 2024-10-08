<?php

use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', function () { return view('auth.login'); })->name('login');
Route::post('login', [UserController::class, 'login'])->name('login.post');

Route::middleware(['auth', 'session.timeout', 'setLocale'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});
