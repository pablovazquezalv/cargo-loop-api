<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company\Company;
use App\Models\Roles\Rol;
use App\Models\Invitation\Invitation;

use App\Models\Trasportista\Dealer;




class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

      

        // Suponiendo que ya tienes estas funciones implementadas en algún servicio o modelo
        // $dashboardData = [
        //     'unidades' => \App\Models\Unit::where('company_id', $companyId)->count(),
        //     'transportistas' => \App\Models\User::where('company_id', $companyId)->where('role', 'driver')->count(),
        //     'entregasCompletas' => \App\Models\Delivery::where('company_id', $companyId)->where('status', 'completado')->count(),
        //     'entregasEnProceso' => \App\Models\Delivery::where('company_id', $companyId)->where('status', 'en_proceso')->count(),
        // ];
        $repartidores = Dealer::all() ?? collect();
        $empresas = Company::all() ?? collect();
        // Obtener los usuarios que se registraron hoy, excluyendo los administradores
        $nuevosUsuarios = User::where('rol_id', '!=', '1') // Excluir administradores
            ->get() ?? collect();
        // Renderizar la vista del dashboard con los datos obtenidos
        return view('admin.dashboard', compact('nuevosUsuarios', 'repartidores', 'empresas'));
    }
    // // public function showDashboardAdmin()
    // // {
    // //     //$nuevosUsuarios = User::whereDate('created_at', today())->get() ?? collect();
      
    // //     return view('admin.dashboard', compact('nuevosUsuarios', 'repartidores'));
    // // }

    public function verRepartidores()
{
    $repartidores = Dealer::all() ?? collect();


    return view('admin.dealers', compact('repartidores'));
}

public function verUsuarios()
{
    $usuarios = User::where('rol_id', '!=', '1')->get() ?? collect();

    return view('admin.users', compact('usuarios'));
}

public function verEmpresas()
{
    $empresas = Company::all() ?? collect();

    return view('admin.empresas', compact('empresas'));
}

}
