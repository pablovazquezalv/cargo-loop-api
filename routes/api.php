<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cliente\UserClienteController;
use App\Http\Controllers\Dealer\DealerController;
use App\Http\Controllers\Manager\CompanyController;
use App\Http\Controllers\Client\ClientController;

use App\Http\Controllers\Manager\ManagerController;



Route::prefix('dealer')->group(function () {
    Route::get('/', [DealerController::class, 'index']); // Listar todos los transportistas
    Route::post("/register", [DealerController::class, "register"]);
    Route::post('/loginWithPhone', [DealerController::class, 'loginWithPhone']); // Iniciar sesión con teléfono
    Route::get('/{id}', [DealerController::class, 'show']); // Mostrar un transportista específico
    Route::put('/{id}', [DealerController::class, 'update']); // Actualizar un transportista
    Route::delete('/{id}', [DealerController::class, 'destroy']); // Eliminar un transportista
});
Route::prefix('client')->group(function () {
    Route::get('/', [ClientController::class, 'index']); // Listar clientes
    Route::post("/Registro", [ClientController::class, "create_user"]);
    Route::get('/{id}', [ClientController::class, 'show']); // Mostrar cliente
    Route::put('/{id}', [ClientController::class, 'update']); // Actualizar cliente
    Route::delete('/{id}', [ClientController::class, 'destroy']); // Eliminar cliente
});
Route::prefix('manager')->group(function () {
    Route::get('/', [ManagerController::class, 'index']); // Listar todos los managers
    Route::post("/register", [ManagerController::class, "register"]);
    Route::post('/loginWithPhone', [ManagerController::class, 'loginWithPhone']); // Iniciar sesión con teléfono
    Route::get('/{id}', [ManagerController::class, 'show']); // Mostrar un manager específico
    Route::put('/{id}', [ManagerController::class, 'update']); // Actualizar un manager
    Route::delete('/{id}', [ManagerController::class, 'destroy']); // Eliminar un manager
});



