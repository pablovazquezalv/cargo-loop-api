<?php
namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Dealer;
use Illuminate\Http\Request;
use App\Models\Invitation\Invitation;
use App\Mail\InvitationMail;
use App\Models\Otp\LoginOtpModel;
use App\Models\Manager\Manager;
use App\Models\Company\Company;
use Illuminate\Support\Facades\Hash;
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

    //login with phone
    public function loginWithPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:10',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Dealer::where('phone', $request->phone)->first();
       
        if($user && Hash::check($request->password, $user->password)) {
            // Generar un token de acceso
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'message' => 'Inicio de sesión exitoso.',
                'data' => $user,
                'token' => $token
            ], 200);


        }
        else {
            return response()->json([
                'message' => 'Credenciales incorrectas.'
            ], 401);
        }

        // Lógica para autenticar al transportista usando el número de teléfono y la contraseña
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
