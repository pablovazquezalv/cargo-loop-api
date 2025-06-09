<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cliente\UserClienteController;
use App\Http\Controllers\Dealer\DealerController;
use App\Http\Controllers\Manager\CompanyController;
use App\Http\Controllers\Client\ClientController;

use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Manager\ManagerController;



Route::prefix('dealer')->group(function () {
    Route::get('/', [DealerController::class, 'index']); // Listar todos los transportistas
    Route::post("/register", [DealerController::class, "register"]);
    Route::post('/loginWithPhone', [DealerController::class, 'loginWithPhone']); // Iniciar sesión con teléfono
    Route::get('/{id}', [DealerController::class, 'show']); // Mostrar un transportista específico
    Route::put('/{id}', [DealerController::class, 'update']); // Actualizar un transportista
    Route::delete('/{id}', [DealerController::class, 'destroy']); // Eliminar un transportista
    Route::post('/register/step1', [DealerController::class, 'registerPrimerPaso']);
    Route::post('/register/step2', [DealerController::class, 'registerSegundoPaso']);
    Route::post('/register/step3', [DealerController::class, 'registerTercerPaso']);
    Route::post('/loginWithPhone', [DealerController::class, 'loginWithPhone']);
    Route::post('/ubication', [DealerController::class, 'ubicacion']);
    Route::post('/verifyCode', [DealerController::class, 'verifyCode']);
    Route::post('/joinCompany', [DealerController::class, 'joinCompany']);
});
Route::prefix('client')->group(function () {
    Route::get('/', [ClientController::class, 'index']); // Listar clientes
    Route::post('/loginWithPhone', [ClientController::class, 'loginWithPhone']); // Iniciar sesión con teléfono
    Route::post("/Registro", [ClientController::class, "create_user"]);
    Route::get('/{id}', [ClientController::class, 'show']); // Mostrar cliente
    Route::put('/{id}', [ClientController::class, 'update']); // Actualizar cliente
    Route::delete('/{id}', [ClientController::class, 'destroy']); // Eliminar cliente
    


});
Route::prefix('manager')->group(function () {
    Route::get('/', [ManagerController::class, 'index']); // Listar todos los managers
    Route::post('/loginWithMail', [ManagerController::class, 'loginWithMail']); // Iniciar sesión con correo electrónico
    Route::post("/register", [ManagerController::class, "register"]);
    Route::post('/createCompany', [ManagerController::class, 'createCompany'])->middleware('auth:sanctum'); // Crear una empresa
    Route::post('/activeAccount', [ManagerController::class, 'activeAccount']); // Activar cuenta
    //Verificar token
    Route::post('/verifyToken', [ManagerController::class, 'verifyToken'])->name('manager.verify.token')->middleware('auth:sanctum'); // Verificar token
    Route::post('/loginWithPhone', [ManagerController::class, 'loginWithPhone']); // Iniciar sesión con teléfono
    Route::delete('/{id}', [ManagerController::class, 'destroy']); // Eliminar un manager
    Route::get('/dashboard', [ManagerController::class, 'dashboardData'])->middleware('auth:sanctum'); // Dashboard del manager
    //invitations
    Route::post('/invitations', [ManagerController::class, 'createInvitationCode'])->middleware('auth:sanctum')->name('invite'); // Enviar invitación
  
    //forgetPassword
    Route::post('/forgetPassword', [ManagerController::class, 'forgetPassword']); // Olvidé mi contraseña
    Route::get('/resetPassword', [ManagerController::class, 'verifyCodeView'])->name('reset.password.view'); // Restablecer contraseña
    Route::post('/resetPassword/{id}', [ManagerController::class, 'resetPassword'])->name('reset.password'); // Restablecer contraseña
});







