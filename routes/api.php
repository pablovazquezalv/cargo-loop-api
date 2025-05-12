<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Trasportista\UserTransportistaController;
use App\Http\Controllers\Cliente\UserClienteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('user_transportista')->group(function () {
    Route::get('/', [UserTransportistaController::class, 'index']); // Listar todos los transportistas
    Route::post('/', [UserTransportistaController::class, 'store']); // Crear un nuevo transportista
    Route::get('/{id}', [UserTransportistaController::class, 'show']); // Mostrar un transportista específico
    Route::put('/{id}', [UserTransportistaController::class, 'update']); // Actualizar un transportista
    Route::delete('/{id}', [UserTransportistaController::class, 'destroy']); // Eliminar un transportista
});

Route::prefix('clientes')->group(function () {
    Route::get('/', [UserClienteController::class, 'index']); // Listar clientes
    Route::post("/Registro", [UserClienteController::class, "create_user"]);
    Route::get('/{id}', [UserClienteController::class, 'show']); // Mostrar cliente
    Route::put('/{id}', [UserClienteController::class, 'update']); // Actualizar cliente
    Route::delete('/{id}', [UserClienteController::class, 'destroy']); // Eliminar cliente
});

Route::post('/login', [UserClienteController::class, 'login']);
Route::post('/verify-code', [UserClienteController::class, 'verifyCode']);


