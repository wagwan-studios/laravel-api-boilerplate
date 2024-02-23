<?php

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware(['guest:api'])->controller(AuthenticationController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('password/forgot-password', 'forgotPassword');
    Route::post('password/reset', 'reset');
});

Route::middleware(['auth:api'])->controller(AuthenticationController::class)->group(function(){
    Route::get('logout', 'logout');
});
