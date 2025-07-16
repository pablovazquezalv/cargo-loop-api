<?php

namespace App\Http\Controllers\Client;

use App\Models\Client\ClientModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Roles\rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Models\Client\ClientModel as Client;

use App\Models\pedido\pedidos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    
    
    /**
     * Crear un nuevo cliente.
     */
    public function register(Request $request){
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
        $cliente->password = Hash::make($request->password);
        $cliente->phone = $request->phone;
        $cliente->rol_id = 4;

        if (!$cliente->save()) {
            return response()->json(['message' => 'Error al crear el cliente.'], 500);
        }
        return response()->json(['message' => 'Cliente creado exitosamente.', 'data' => $cliente], 201);

    }

 
    /**
     * Iniciar sesión con el número de teléfono.
     */
    public function loginWithMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }



        $user = Client::where('email', $request->email)->first();
            
       

        if($user && Hash::check($request->password, $user->password))
        {
            $token = $user->createToken('token')->plainTextToken;

            return response()->json(['message' => 'Autenticación exitosa.', 'token' => $token,
        $user->only(['id', 'name', 'email', 'phone', 'rol_id'])
        ]);
    }
    return response()->json(['message' => 'Cliente no encontrado.'], 404);
    }

    public function logout(Request $request)
    {
       #tomar el token del usuario autenticado
        $user = $request->user();
        if ($user) {
            // Revocar el token del usuario
            $user->tokens()->delete();
            return response()->json(['message' => 'Sesión cerrada exitosamente.']);
        }
        return response()->json(['message' => 'Usuario no autenticado.'], 401);
    }
    /**
     * Verificar el código y generar un token.
     */
    public function verifyCode(Request $request)
    {
        $validated = $request->validate([
            'Telefono' => 'required|string|max:15',
            'code' => 'required|string',
        ]);

        $cliente = ClientModel::where('Telefono', $validated['Telefono'])->first();

        if (!$cliente || !Hash::check($validated['code'], $cliente->code)) {
            return response()->json(['message' => 'Código incorrecto.'], 401);
        }

        // Generar un token (usando Laravel Sanctum o Passport)
        $token = $cliente->createToken('auth_token')->plainTextToken;

        // Limpiar el código después de la validación
        $cliente->code = null;
        $cliente->save();

        return response()->json(['message' => 'Autenticación exitosa.', 'token' => $token]);
    }

    public function show($id)
    {
        $cliente = ClientModel::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }

        return response()->json($cliente);
    }
    //
        
    public function index()
    {
        $clientes = ClientModel::all();
        return response()->json($clientes);
    }
    public function destroy($id)
    {
        $cliente = ClientModel::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }

        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado exitosamente.']);
    }

    public function contactoInformes(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email',
            'mensaje' => 'required|string',
        ]);
        Mail::raw($validator['mensaje'], function ($message) use ($validator) {
            $message->to('no-reply@mx.cargo-loop.com') // cambia por tu correo real
                    ->subject('Nuevo mensaje de contacto')
                    ->from($validator['email']);
        });
    
        return back()->with('success', 'Mensaje enviado con éxito.');
         
    }

 public function pedidoPorcliente(Request $request)
    {
      try {
    $validated = $request->validate([
        'cliente_id' => 'required',
    ]);
    
    $pedidos = pedidos::where('cliente_id', $request->cliente_id)->get();
    if ($pedidos->isEmpty()) {
        return response()->json(['message' => 'No se encontraron pedidos para este cliente.'], 404);
    }
    return response()->json(['message' => 'Pedidos encontrados.', 'data' => $pedidos], 200);
    
} catch (ValidationException $e) {
    return response()->json([
        'message' => 'Errores de validación.',
        'errors' => $e->errors()
    ], 422);
}
        
    } 

  public function pedidoActual(Request $request)
{
    $validator = Validator::make($request->all(), [
        'cliente_id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Errores de validación.',
            'errors' => $validator->errors()
        ], 422);
    }

    $clienteId = $request->cliente_id;

    $pedidoActual = DB::table('pedidos')
        ->where('cliente_id', $clienteId)
        ->where('estado_pedido', '!=', 'Finalizado')
        ->orderByDesc('id') // opcional: si deseas el más reciente
        ->first();

    if ($pedidoActual) {
        return response()->json(['pedido' => $pedidoActual], 200);
    }

    return response()->json([
        'message' => 'No se encontró un pedido en curso para este cliente.'
    ], 404);
}

}