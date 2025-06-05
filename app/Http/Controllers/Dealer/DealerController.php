<?php
namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Invitation\Invitation;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\CodeVerificationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Trasportista\Dealer;
use Illuminate\Support\Facades\DB;

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
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:10',
            'independiente'=>'required|boolean',
        ]);
       
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }
        else{ 
            // Usar DB para insertar directamente en la tabla users
            $user = new Dealer();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->rol_id = 3; // Asignar rol de transportista por defecto
            $user->independiente = $request->independiente;

            if($user->save()){ // <-- ¡Aquí está la corrección!
                return response()->json([
                    'message' => 'Usuario creado exitosamente.',
                    'data' => $user,
                ], 201);
            } 
            return response()->json([
                'message' => 'Error al crear el usuario.'
            ], 500);
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
            'picture_license' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'proof_of_residence' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo_identification' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rfc' => 'required',
            'letter_of_no_criminal_record' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tipo_de_licencia_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->address = $request->address;
        $user->nss = $request->nss;
    
        // Guardar archivos en public y almacenar la ruta
        if ($request->hasFile('picture_license')) {
            $file = $request->file('picture_license');
            $filename = 'user_' . $user->id . '_licencia.' . $file->getClientOriginalExtension();
            $user->picture_license = $file->storeAs('licencias', $filename, 'public');
        }
        if ($request->hasFile('photo_identification')) {
            $file = $request->file('photo_identification');
            $filename = 'user_' . $user->id . '_identificacion.' . $file->getClientOriginalExtension();
            $user->photo_identification = $file->storeAs('identificaciones', $filename, 'public');
        }
        if ($request->hasFile('letter_of_no_criminal_record')) {
            $file = $request->file('letter_of_no_criminal_record');
            $filename = 'user_' . $user->id . '_no_criminal.' . $file->getClientOriginalExtension();
            $user->letter_of_no_criminal_record = $file->storeAs('no_criminal', $filename, 'public');
        }
        if ($request->hasFile('proof_of_residence')) {
            $file = $request->file('proof_of_residence');
            $filename = 'user_' . $user->id . '_comprobante.' . $file->getClientOriginalExtension();
            $user->proof_of_residence = $file->storeAs('proof_of_residence', $filename, 'public');
        }
    
        $user->rfc = $request->rfc;
        $user->type_license = $request->tipo_de_licencia_id;
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
        }

        // Generar un código de 4 dígitos y convertirlo a string

        if ($cliente->status == 0) {
            return response()->json([
               'message' => 'Cuenta desactivada.'
            ], 404);
        }
        $code = strval(rand(1000, 9999));

        // Enviar el código por correo electrónico
        

        // Guardar el código encriptado en la base de datos
        $cliente->code = $code;
        Mail::to($cliente->email)->send(new CodeVerificationMail($cliente));
        if ($cliente->save()) {
            // Aquí puedes usar un servicio de SMS para enviar el código si lo deseas
            return response()->json([
                'message' => 'Código enviado al número de teléfono.',
                'data' => $cliente->only(['phone'])
                // El código solo debería enviarse por SMS/correo, pero puedes devolverlo aquí para pruebas
                
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error al enviar el código.'
            ], 500);
        }
    }

    public function verifyCode(Request $request)
{
    $validator = Validator::make($request->all(), [
        'phone' => 'required',
        'code' => 'required'
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
    if ($request->code != $cliente->code) {
        return response()->json([
            'message' => 'Código incorrecto.'
        ], 422);
    }

    // Verificar si ya tiene invitado = 1
    

    // Generar un token de acceso
    if ($cliente->incompany == 1) {
        $empresa = DB::table('companies')
        ->where('id', $cliente->company_id)
        ->first();
        $company = $empresa;
        $token = $cliente->createToken('access_token')->plainTextToken;
        return response()->json([
           'message' => 'Código verificado exitosamente',
            'token' => $token,
            'user' => $cliente,
            'company' => $company
        ], 200);
    }else{
       

    // Devolver el token y estado de invitado
    return response()->json([
        'message' => 'Código verificado exitosamente',
        'token' => null,
        'user' => $cliente
    ], 200);
    }
   
    
}


    //unirse a una empresa por un id y codigo
    public function joinCompany(Request $request)
    {
     
        // Validar los datos de la solicitud
       $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'email' => 'required|email'

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
                'message' => 'La invitación ya ha sido aceptada.',
                'data' => $invitation,
               
            ], 422);
        }
        //actualizar al transportista
        $transportista = Dealer::where('email', $request->email)->firstOrFail();
        $transportista->company_id = $invitation->company_id;
        $transportista->incompany = 1;
        $transportista->save();

        // Marcar la invitación como aceptada
        $invitation->accepted_at = now();
        $invitation->save();
        return response()->json([
            'message' => 'Invitación aceptada exitosamente.',
            'data' => $invitation,
            'transportista' => $transportista
        ], 200);



        // Lógica para unirse a la empresa usando el ID y el código proporcionados
    }
    public function ubicacion(Request $request){
        $validator = Validator::make($request->all(), [
            'latitude' =>'required',
            'longitude' =>'required',
            'email' =>'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
               'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);

        }
        $dealer = Dealer::where('email', $request->email)->firstOrFail();
        $dealer->latitude = $request->latitude;
        $dealer->longitude = $request->longitude;
        $dealer->save();
        return response()->json([
            'message' => 'Ubicación actualizada exitosamente.',
            'data' => $dealer
        ]);
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
