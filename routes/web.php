<?php

use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Client\ClientController;


use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/clientes/{cliente}/toggle-status', [AdminController::class, 'toggleStatus'])->name('clientes.toggleStatus');

Route::get('/login', [ManagerController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ManagerController::class, 'loginWithMail'])->name('login.attempt');
Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard');
Route::get('/dashboard-admin',[AdminController::class, 'index'])->name('dashboard-admin');;
// routes/web.php
Route::get('/repartidores-admin', [AdminController::class, 'verRepartidores'])->name('repartidores');
Route::get('/usuarios-admin', [AdminController::class, 'verUsuarios'])->name('usuarios');
Route::get('/empresas-admin', [AdminController::class, 'verEmpresas'])->name('empresas');
Route::post('/logout', [ManagerController::class, 'logout'])->name('logout');

Route::get('/manager/create-company', [ManagerController::class, 'showCreateForm'])->name('manager.createForm');
Route::post('/manager/create-company', [ManagerController::class, 'createCompany'])->name('manager.createCompany');

Route::post('/invitation', [ManagerController::class, 'createInvitationCode'])->name('invite');
Route::get('/register', [ManagerController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [ManagerController::class, 'register'])->name('register.manager');

Route::post('/password/email', [ManagerController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/contactoInformes',[ClientController::class,'contactoInformes'])->name('contacto.enviar');
    Route::post('/forgetPassword', action: [ManagerController::class, 'forgetPassword'])->name('password.email'); // Olvidé mi contraseña
