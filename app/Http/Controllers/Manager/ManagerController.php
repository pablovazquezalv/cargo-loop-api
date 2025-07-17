<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use App\Models\pedido\pedidos;
use Illuminate\Http\Request;
use App\Models\Invitation\Invitation;
use App\Mail\InvitationMail;
use App\Models\Manager\Manager;
use App\Models\Otp\LoginOtpModel;
use App\Models\Client\ClientModel;
use Illuminate\Support\Facades\Hash;
use App\Models\User\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\CodeVerificationMail;
use Nette\Utils\Random;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        $companyId = $user->company_id; // puede ser null
        $company = $user->company;


        if ($companyId === null) {
            return view('manager/no_company');
        }

$dashboardData = [
    'transportistas' => $user->company ? $user->company->dealers()->count() : 0,
   # 'cargas' => pedidos::where('id_company', $companyId)->count(),
   # 'entregasCompletadas' => pedidos::where('id_company', $companyId)
   #     ->where('estado_pedido', 'entregado')
    #    ->count(),
    // 'entregasEnProceso' => pedidos::where('id_company', $companyId)
    //     ->where('estado_pedido', 'en_proceso')
    //     ->count(),
    'nuevosUsuarios' => \App\Models\User::where('company_id', $companyId)
        ->whereDate('created_at', '>=', now()->subDays(7)) // Ejemplo últimos 7 días
        ->count(),
];
        return view('manager.dashboard', [
            'user' => $user,
            'company' => $company,
            'dashboardData' => $dashboardData,
        ]);
    }

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
           
          $cliente = new ClientModel();
          $cliente->name = $request->name;
          $cliente->email = $request->email;
          $cliente->rol_id = 3; // Asignar el rol de manager
          $cliente->password = Hash::make($request->password);
          $cliente->phone = $request->phone;

          #mandar correo de verificacion
        $code = Random::generate(4, '0-9');
        $cliente->code = $code;
        $cliente->save();

        // try {
        //     Mail::to($cliente->email)->send(new CodeVerificationMail($cliente));
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Error al enviar el correo electrónico.',
        // 'error' => $e->getMessage()], 500);
        // }


  
          if (!$cliente->save()) {
              return response()->json(['message' => 'Error al crear el cliente.'], 500);
          }
         #mandar a vista login con exito
          return redirect()->route('login')
          ->with('success', 'Usuario creado exitosamente. Por favor, verifica tu correo electrónico para activar tu cuenta.');
    }
  
    //showRegistrationForm
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    public function activeAccount(Request $request)
    {
        $user = Manager::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        if ($user->code !== $request->code) {
            return response()->json(['message' => 'Código incorrecto.'], 422);
        }

        // Actualizar el estado del usuario a activo
        $user->status = 1; // Cambiar el estado a activo
        $user->code = null; // Limpiar el código después de la verificación
        $user->save();

        return response()->json(['message' => 'Cuenta activada exitosamente.'], 200);
    }
    

    public function showCreateForm()
    {
        return view('manager.create-company');
    }
    public function createCompany(Request $request)
    {

        $user = Auth::user();

       $userId = $user->id;


        //Validar los datos de la empresa
        $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|unique:companies,name',
        'business_name' => 'nullable|string|max:255',
        'email' => 'required|string|email|max:255|unique:companies,email',
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
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        //Crear la empresa
       // Crear la empresa
$company = new Company();
$company->name = $request->name;
$company->business_name = $request->business_name;
$company->email = $request->email;
$company->phone = $request->phone;
$company->address = $request->address;
$company->city = $request->city;
$company->state = $request->state;
$company->country = $request->country;
$company->postal_code = $request->postal_code;
$company->website = $request->website;
$company->description = $request->description;

// Solo si hay archivo, se guarda y se asigna el path
if ($request->hasFile('profile_picture')) {
    $imagePath = $request->file('profile_picture')->store('companies', 'public');
    $company->profile_picture = $imagePath;
}

$company->save();


        // Asignar la empresa al usuario
        $user = Manager::find($userId);
        if (!$user) {

            // Si el usuario no existe, retornar un error
            return redirect()->back()
            ->with('error', 'Usuario no encontrado.')   
            ->withInput();
        }
        $user->company_id = $company->id;
        $user->save();

        return redirect()->route('dashboard') // 👈 Cambia a la ruta de tu pane
        ->with('success', 'Empresa creada exitosamente. Ahora puedes invitar a transportistas.');
       
    }

    //crear codigo de invitacion
    public function createInvitationCode(Request $request)
    {
        // Validar los datos de la invitación
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

        $manager = Auth::user();

        $code = Invitation::generateCode();

        $invitation = Invitation::create([
            'company_id' => $manager->company_id,
            'user_id' => $manager->id,
            'email' => $request->email,
            'code' => $code,
        ]);

        try{
            Mail::to($request->email)->send(new InvitationMail($invitation));
            return redirect()->back()
            ->with('success', 'Invitación enviada exitosamente al correo: ' . $request->email);
        } catch (\Exception $e) {

            return redirect()->back()
            ->with('error', 'Error al enviar la invitación: ' . $e->getMessage())
            ->withInput();
        }

        
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

            if($user->id === 1)
            {

                Auth::login($user);
                $token = $user->createToken('token')->plainTextToken;

                return redirect()->route('dashboard-admin'); // 👈 Cambia a la ruta de tu panel

            }

          #si usuario es diferente de 1
            if($user->id !== 1)
            {
                // Si el usuario es un manager o cliente, redirigir al dashboard del manager
                Auth::login($user);
                $token = $user->createToken('token')->plainTextToken;

                return redirect()->route('dashboard'); // 👈 Cambia a la ruta de tu panel
            }
            {
                Auth::login($user);
                $token = $user->createToken('token')->plainTextToken;

                return redirect()->route('dashboard'); // 👈 Cambia a la ruta de tu panel
            }



            
        } else {
            return redirect()->back()
            ->with('error', 'El correo electrónico o la contraseña son incorrectos.')
            ->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('/auth/login');
    }
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Manager::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()
            ->with('error', 'Usuario no encontrado.')
        
            ->withInput();
        }

        // Generar un nuevo token de restablecimiento de contraseña
        $code= Random::generate(4, '0-9');
        $user = Manager::find($user->id);
        $user->code = $code;
        $user->save();


        $url = URL::temporarySignedRoute(
            'reset.password.view', now()->addMinutes(30), ['email' => $user->email, 'code' => $code]
        );


        // Enviar el token por correo electrónico
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user, $url));

            return redirect()->back()
            ->with('success', 'Se ha enviado un enlace de restablecimiento de contraseña a tu correo electrónico.')
            ->withInput();
        } catch (\Exception $e) {

            return redirect()->back()
            ->with('error', 'Error al enviar el correo electrónico: ' . $e->getMessage())
            ->withInput();
        
        }
      
       
    }
    //mandar vista para verificar el codigo 
    public function verifyCodeView(Request $request)
    {
       $user = Manager::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return view('codeView', ['user' => $user]);
    }

    public function resetPassword(Request $request,$id)
    {
        $user = Manager::find($id);


        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        $codeArray = $request->input('code');
        $fullCode = implode('', $codeArray); // "7906"



        if ($user->code !== $fullCode) {
            return response()->json(['message' => 'Código incorrecto.'], 422);
        }

        // Actualizar la contraseña
        $user->password = Hash::make($request->password);
        $user->code = null; // Limpiar el código después de restablecer la contraseña
        $user->save();

        return response()->json(['message' => 'Contraseña restablecida exitosamente.'], 200);
    }

    public function verifyToken(Request $request)
    {
        $user = $request->user();
        
        if($user)
        {
            return response()->json([
                'message' => 'Token válido',
                'id' => $user->id,
                'role' => $user->role,
                'status' => $user->status,
                'company_id' => $user->company_id,
            ], 200);
        }
        return response()->json(['message' => 'Token inválido'], 401);
    }

    public function dashboardData(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado.'], 401);
        }

       
        return response()->json([
            'message' => 'Datos del dashboard obtenidos exitosamente.',
            'data' => [
                'unidades' => 
                $user->company ? $user->company->units()->count() : 0,
                'transportistas' =>
                $user->company ? $user->company->dealers()->count() : 0,
                'entregas completadas' =>
                $user->company ? $user->company->deliveries()->where('status', 'completed')->count() : 0,
                'entregas pendientes' =>
                $user->company ? $user->company->deliveries()->where('status', 'pending')->count() : 0,
            ]
        ], 200);
    }

    

    //funcion para ver si tiene company_id
    public function hasCompanyId($id)
    {
        $user = Manager::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        if ($user->company_id) {
            return response()->json(['message' => 'El usuario tiene company_id.'], 200);
        } else {
            return response()->json(['message' => 'El usuario no tiene company_id.'], 200);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Revocar el token del usuario
            
            return redirect('/login')->with('success', 'Sesión cerrada exitosamente.');
        }

        return redirect('/login')->with('error', 'Usuario no autenticado.');
    }


      
}
