<?php

use Illuminate\Http\Request;
use App\Http\Controllers\DvUserController;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('login', function () { return view('auth.login'); })->name('login');
Route::post('login', [DvUserController::class, 'login'])->name('login.post');

Route::middleware(['auth', 'session.timeout', 'setLocale'])->group(function () {
    Route::get('dvusers', [DvUserController::class, 'index'])->name('dvusers.index');
    Route::post('dvusers', [DvUserController::class, 'store']);
    Route::put('dvusers/{id}', [DvUserController::class, 'update']);
    Route::delete('dvusers/{id}', [UserDvUserController::class, 'destroy']);
    Route::post('dvusers/{id}/roles', [DvUserController::class, 'attachRoles'])->name('dvusers.attachRoles');
Route::post('dvusers/{id}/roles/detach', [DvUserController::class, 'detachRoles'])->name('dvusers.detachRoles');


    Route::get('dvuserroles', [DvUserRoleController::class, 'index'])->name('dvuserroles.index');
    Route::post('dvuserroles', [DvUserRoleController::class, 'store'])->name('dvuserroles.store');
    Route::put('dvuserroles/{id}', [DvUserRoleController::class, 'update']);
    Route::delete('dvuserroles/{id}', [DvUserRoleController::class, 'destroy']);
});
