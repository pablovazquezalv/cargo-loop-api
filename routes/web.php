<?php

use App\Http\Controllers\Manager\ManagerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [ManagerController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ManagerController::class, 'loginWithMail'])->name('login.attempt');

Route::get('/register', [ManagerController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [ManagerController::class, 'register'])->name('register.manager');

Route::post('/password/email', [ManagerController::class, 'sendResetLinkEmail'])->name('password.email');