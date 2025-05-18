<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use Illuminate\Http\Request;
use App\Models\Invitation\Invitation;
use App\Mail\InvitationMail;
use App\Models\Manager\Manager;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    
    public function createCompany(Request $request)
    {

        //obtener el id de usuario que hara creara la empresa
        $userId = $request->input('user_id');

        //Validar los datos de la empresa
        $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'business_name' => 'nullable|string|max:255',
        'email' => 'required|string|email|max:255|unique:company,email',
        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:10',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'website' => 'nullable|url|max:255',
        'description' => 'nullable|string|max:1000',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }
        //Crear la empresa
        $company = new Company();
        $company->name = $request->input('name');
        $company->business_name = $request->input('business_name');
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->address = $request->input('address');
        $company->city = $request->input('city');
        $company->state = $request->input('state');
        $company->country = $request->input('country');
        $company->postal_code = $request->input('postal_code');
        $company->profile_picture = $request->input('profile_picture');
        $company->website = $request->input('website');
        $company->description = $request->input('description');
        $company->user_id = $userId; // Asignar el ID del usuario que creó la empresa
        $company->save();

        return response()->json([
            'message' => 'Empresa creada exitosamente.',
            'data' => $company
        ], 201);
       
    }

    //crear codigo de invitacion
    public function createInvitationCode(Request $request)
    {
        // Validar los datos de la invitación
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        $manager = $request->user();

        $code = Invitation::generateCode();

        $invitation = Invitation::create([
            'company_id' => $manager->company_id,
            'manager_id' => $manager->id,
            'email' => $request->email,
            'code' => $code,
        ]);

        Mail::to($request->email)->send(new InvitationMail($invitation));

        return response()->json(['message' => 'Invitación enviada con éxito.']);
    }

    //iniciar sesion con el correo y contraseña
    public function loginWithMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:30',
        ]);

        $user = Manager::where('email', $request->email)->first();
            

        if($user && Hash::check($request->password, $user->password))
        {
            // Iniciar sesión y generar token
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'message' => 'Inicio de sesión exitoso.',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 200);
            
        } else {
            return response()->json(['message' => 'Credenciales incorrectas.'], 401);
        }
    }

      
}
