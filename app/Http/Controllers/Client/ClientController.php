<?php

namespace App\Http\Controllers\Client;

use App\Models\Client\ClientModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

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

        if (!$cliente->save()) {
            return response()->json(['message' => 'Error al crear el cliente.'], 500);
        }
        return response()->json(['message' => 'Cliente creado exitosamente.', 'data' => $cliente], 201);

    }

 
    /**
     * Iniciar sesión con el número de teléfono.
     */
    public function loginWithPhone(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:15',
        ]);


        $cliente = ClientModel::where('phone', $validated['phone'])->first();

        if (!$cliente) {
            return response()->json(['message' => 'Número de teléfono no encontrado.'], 404);
        }

        
        $code = rand(1000, 9999);

        
        $cliente->code = Hash::make($code);
        $cliente->save();

        // Aquí puedes enviar el código al cliente (por SMS o correo electrónico)
        // Por simplicidad, lo devolvemos en la respuesta
        return response()->json(['message' => 'Código generado.', 'code' => $code]);
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
}
