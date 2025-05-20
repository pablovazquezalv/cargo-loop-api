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
use App\Mail\CodeVerificationMail;
use Illuminate\Support\Facades\Mail;


class DealerController extends Controller
{
   

    /**
     * Crear un nuevo transportista.
     */
    public function registerPrimerPaso(Request $request)
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
        else{ 
            $user = Dealer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'rol_id' => 3, // Asignar el rol de transportista
            ]);
            return response()->json([
                'message' => 'Usuario creado exitosamente.',
                'data' => $user->only(['id', 'name', 'email', 'phone'])
            ], 201);
        }

    }
     public function registerSegundoPaso(Request $request)
    {
        $user = Dealer::find($request->id);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado.'
            ], 404);
        }
        
        
          $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'nss' => 'required',
            'picture_license' => 'required',
            'proof_of_residence' => 'required',
            'photo_identification' => 'required',
            'rfc' => 'required',
            'letter_of_no_criminal_record' => 'required',
            'tipo_de_licencia_id' => 'required|exists:tipo_de_licencia,id',
            
        ]);
         if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->address = $request->address;
        $user->nss = $request->nss; 
        $user->picture_license = $request->picture_license;
        $user->proof_of_residence = $request->proof_of_residence;
        $user->photo_identification = $request->photo_identification;
        $user->rfc = $request->rfc;
        $user->letter_of_no_criminal_record = $request->letter_of_no_criminal_record;
        $user->tipo_de_licencia_id = $request->tipo_de_licencia_id;
        $user->save();
        if ($user) {
            return response()->json([
                'message' => 'Usuario actualizado exitosamente.',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error al actualizar el usuario.'
            ], 500);
        }
       
       

    }

    public function registerTercerPaso(Request $request)
    {
        $user = Dealer::find($request->id);
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado.'
            ], 404);
        }
        
          $validator = Validator::make($request->all(), [
            'rol' => 'required|in:1,2,3',
            
        ]);
         if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }
        else{ 
            $user->rol_id = $request->rol;
            $user->save();
            return response()->json([
                'message' => 'Usuario actualizado exitosamente.',
                'data' => $user
            ], 200);
        }

       

    }




    //login with phone
    public function loginWithPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:10',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

        $cliente = Dealer::where('phone', $request->phone)->first();
        if (!$cliente) {
            return response()->json([
                'message' => 'Número de teléfono no encontrado.'
            ], 404);
         // Generar un código de 4 dígitos
        $code = rand(1000, 9999);

        // Encriptar y guardar el código en la base de datos
         // Aquí puedes usar un servicio de SMS para enviar el código
         //smtp
         
         Mail::to($cliente->email)->send(new CodeVerificationMail($code));
            


        $cliente->code = Hash::make($code);
       if( $cliente->save()){
            // Enviar el código al número de teléfono del cliente
            // Aquí puedes usar un servicio de SMS para enviar el código
            // Por ejemplo, Twilio, Nexmo, etc.
            return response()->json([
                'message' => 'Código enviado al número de teléfono.',
                'code' => $code
            ], 200);
        }else{
            return response()->json([
                'message' => 'Error al enviar el código.'
            ], 500);
        }
        }
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:10',
            'code' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }
        $cliente = Dealer::where('phone', $request->phone)->first();
        if (!$cliente) {
            return response()->json([
                'message' => 'Número de teléfono no encontrado.'
            ], 404);
        }
        // Verificar el código
        if (!Hash::check($request->code, $cliente->code)) {
            return response()->json([
                'message' => 'Código incorrecto.'
            ], 422);
        }
        // Generar un token de acceso
        $token = $cliente->createToken('access_token')->plainTextToken;
        // Devolver el token al cliente
        return response()->json([
            'message' => 'Código verificado exitosamente',
            'token' => $token,
            'user' => $cliente->only(['id', 'name', 'email', 'phone'])
        ], 200);


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


public function index()
{
    return response()->json(Dealer::all());
}

public function show($id)
{
    $dealer = Dealer::find($id);
    if (!$dealer) {
        return response()->json(['message' => 'Transportista no encontrado'], 404);
    }
    return response()->json($dealer);
}

public function update(Request $request, $id)
{
    $dealer = Dealer::find($id);
    if (!$dealer) {
        return response()->json(['message' => 'Transportista no encontrado'], 404);
    }

    $dealer->update($request->all());
    return response()->json(['message' => 'Transportista actualizado', 'data' => $dealer]);
}

public function destroy($id)
{
    $dealer = Dealer::find($id);
    if (!$dealer) {
        return response()->json(['message' => 'Transportista no encontrado'], 404);
    }

    $dealer->delete();
    return response()->json(['message' => 'Transportista eliminado']);
}


   
}
