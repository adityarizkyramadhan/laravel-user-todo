<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\Jwt;

Route::get('/test', function () {
  return response()->json(['message' => 'API is working!']);
});


Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/error', function () {
  throw new \Exception('Error message', 404);
})->name('error');

Route::middleware([Jwt::class, 'auth:api'])->group(function () {
  Route::get('/profile', [UserController::class, 'profile'])->name('profile');
  Route::post('/logout', [UserController::class, 'logout'])->name('logout');
  Route::post('/refresh', [UserController::class, 'refresh'])->name('refresh');
});
