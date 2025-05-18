<?php
namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Dealer;
use Illuminate\Http\Request;
use App\Models\Invitation\Invitation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DealerController extends Controller
{
   

    /**
     * Crear un nuevo transportista.
     */
    public function register(Request $request)
    {
        
          $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:10'
        ]);
       
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

    }

    //unirse a una empresa por un id y codigo
    public function joinCompany(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:4',
            'email' => 'required|email|exists:invitations,email'

        ]);

        // Validar los datos de la solicitud
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

        $invitation = Invitation::where('code', $request->code)
        ->where('email', $request->email)
        ->firstOrFail();

        // Verificar si la invitación ya ha sido aceptada
        if ($invitation->accepted_at) {
            return response()->json([
                'message' => 'La invitación ya ha sido aceptada.'
            ], 422);
        }
        //actualizar al transportista
        $transportista = Dealer::where('email', $request->email)->firstOrFail();
        $transportista->company_id = $invitation->company_id;
        $transportista->save();

        // Marcar la invitación como aceptada
        $invitation->accepted_at = now();
        $invitation->save();
        return response()->json([
            'message' => 'Invitación aceptada exitosamente.',
            'data' => $invitation
        ], 200);



        // Lógica para unirse a la empresa usando el ID y el código proporcionados
    }







   
    /**
     * Actualizar un transportista existente.
     */
   
}
