<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
        $dashboardData = [
            'unidades' => $user->company ? $user->company->units()->count() : 0,
            'transportistas' => $user->company ? $user->company->dealers()->count() : 0,
            'entregasCompletas' => $user->company ? $user->company->deliveries()->where('status', 'completed')->count() : 0,
            'entregasEnProceso' => $user->company ? $user->company->deliveries()->where('status', 'pending')->count() : 0,
        ];

        return view('admin/dashboard', compact('dashboardData'));
    }
    public function showDashboardAdmin()
    {
        $nuevosUsuarios = User::whereDate('created_at', today())->get() ?? collect();
        $invitaciones = Invitation::latest()->take(10)->get() ?? collect();
        $repartidores = Dealer::all() ?? collect();
    
        return view('admin.dashboard', compact('nuevosUsuarios', 'invitaciones', 'repartidores'));
    }
    
}
