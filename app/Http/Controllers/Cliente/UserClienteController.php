<?php

namespace App\Http\Controllers\Cliente;

use App\Models\Cliente\ClienteModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class UserClienteController extends Controller
{
    //
        
    public function index()
    {
        $clientes = ClienteModel::all();
        return response()->json($clientes);
    }
    public function store(Request $request)
    {
        // Definir las reglas de validación
        $validator = Validator::make($request->all(), [
            'nombre_de_la_empresa' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'rfc' => 'required|string|max:255',
            'no_patronal' => 'required|string|max:255',
            'Clave_Interbencaria_de_la_empresa' => 'required|string|max:255',
            'Comprabante_Fiscal' => 'required|string|max:255',
            'Representante_legal' => 'required|string|max:255',
            'Foto_identificacion' => 'required|string|max:255',
            'Nombre_Del_Contacto_de_la_empresa' => 'required|string|max:255',
            'Telefono' => 'required|string|max:15',
            'Email' => 'required|email|max:255',
            'Puesto' => 'required|string|max:255',
            'Comprobante_de_domicilio' => 'required|string|max:255',
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Crear una nueva instancia del modelo
        $cliente = new ClienteModel();

        // Asignar los valores validados al modelo
        $cliente->nombre_de_la_empresa = $request->nombre_de_la_empresa;
        $cliente->razon_social = $request->razon_social;
        $cliente->direccion = $request->direccion;
        $cliente->rfc = $request->rfc;
        $cliente->no_patronal = $request->no_patronal;
        $cliente->Clave_Interbencaria_de_la_empresa = $request->Clave_Interbencaria_de_la_empresa;
        $cliente->Comprabante_Fiscal = $request->Comprabante_Fiscal;
        $cliente->Representante_legal = $request->Representante_legal;
        $cliente->Foto_identificacion = $request->Foto_identificacion;
        $cliente->Nombre_Del_Contacto_de_la_empresa = $request->Nombre_Del_Contacto_de_la_empresa;
        $cliente->Telefono = $request->Telefono;
        $cliente->Email = $request->Email;
        $cliente->Puesto = $request->Puesto;
        $cliente->Comprobante_de_domicilio = $request->Comprobante_de_domicilio;

        // Guardar el cliente en la base de datos
        if (!$cliente->save()) {
            return response()->json(['message' => 'Error al crear el cliente.'], 500);
        }

        return response()->json(['message' => 'Cliente creado exitosamente.', 'data' => $cliente], 201);
    }
    /**
     * Crear un nuevo cliente.
     */
    public function create_user(Request $request){
      $validator = Validator::make($request->all(), [
            'nombre_de_la_empresa' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'rfc' => 'required|string|max:255',
            'no_patronal' => 'required|string|max:255',
            'Clave_Interbencaria_de_la_empresa' => 'required|string|max:255',
            'Comprabante_Fiscal' => 'required|string|max:255',
            'Representante_legal' => 'required|string|max:255',
            'Foto_identificacion' => 'required|string|max:255',
            'Nombre_Del_Contacto_de_la_empresa' => 'required|string|max:255',
            'Telefono' => 'required|string|max:15',
            'Email' => 'required|email|max:255',
            'Puesto' => 'required|string|max:255',
            'Comprobante_de_domicilio' => 'required|string|max:255',
      
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $validator->errors()
            ], 422);
        }
         
        $cliente = new ClienteModel();
        $cliente->nombre_de_la_empresa = $request->nombre_de_la_empresa;
        $cliente->razon_social = $request->razon_social;
        $cliente->direccion = $request->direccion;
        $cliente->rfc = $request->rfc;
        $cliente->no_patronal = $request->no_patronal;
        $cliente->Clave_Interbencaria_de_la_empresa = $request->Clave_Interbencaria_de_la_empresa;


        $cliente->Comprabante_Fiscal = $request->Comprabante_Fiscal;
        $cliente->Representante_legal = $request->Representante_legal;
        $cliente->Foto_identificacion = $request->Foto_identificacion;
        $cliente->Nombre_Del_Contacto_de_la_empresa = $request->Nombre_Del_Contacto_de_la_empresa;
        $cliente->Telefono = $request->Telefono;
        $cliente->Email = $request->Email;
        $cliente->Puesto = $request->Puesto;
        $cliente->Comprobante_de_domicilio = $request->Comprobante_de_domicilio;

        if (!$cliente->save()) {
            return response()->json(['message' => 'Error al crear el cliente.'], 500);
        }
        return response()->json(['message' => 'Cliente creado exitosamente.', 'data' => $cliente], 201);

    }
    public function show($id)
    {
        $cliente = ClienteModel::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }

        return response()->json($cliente);
    }
    public function update(Request $request, $id)
    {
        $cliente = ClienteModel::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }

        $validated = $request->validate([
            'nombre_de_la_empresa' => 'string|max:255',
            'razon_social' => 'string|max:255',
            'direccion' => 'string|max:255',
            'rfc' => 'string|max:255',
            'no_patronal' => 'string|max:255',
            'Clave_Interbencaria_de_la_empresa' => 'string|max:255',
            'Comprabante_Fiscal' => 'string|max:255',
            'Representante_legal' => 'string|max:255',
            'Foto_identificacion' => 'string|max:255',
            'Nombre_Del_Contacto_de_la_empresa' => 'string|max:255',
            'Telefono' => 'string|max:15',
            'Email' => 'email|max:255',
            'Puesto' => 'string|max:255',
            'Comprobante_de_domicilio' => 'string|max:255',
        ]);

        $cliente->update($validated);
        return response()->json(['message' => 'Cliente actualizado exitosamente.', 'data' => $cliente]);
    }
    public function destroy($id)
    {
        $cliente = ClienteModel::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado.'], 404);
        }

        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado exitosamente.']);
    }

    /**
     * Iniciar sesión con el número de teléfono.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'Telefono' => 'required|string|max:15',
        ]);

        $cliente = ClienteModel::where('Telefono', $validated['Telefono'])->first();

        if (!$cliente) {
            return response()->json(['message' => 'Número de teléfono no encontrado.'], 404);
        }

        // Generar un código de 4 dígitos
        $code = rand(1000, 9999);

        // Encriptar y guardar el código en la base de datos
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

        $cliente = ClienteModel::where('Telefono', $validated['Telefono'])->first();

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
}
