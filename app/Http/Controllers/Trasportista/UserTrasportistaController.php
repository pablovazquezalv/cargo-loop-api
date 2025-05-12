<?php

namespace App\Http\Controllers\Trasportista;

use App\Http\Controllers\Controller;
use App\Models\Trasportista\UserTrasportista;
use Illuminate\Http\Request;

class UserTransportistaController extends Controller
{
    /**
     * Listar todos los transportistas.
     */
    public function index()
    {
        $transportistas = UserTrasportista::all();
        return response()->json($transportistas);
    }

    /**
     * Crear un nuevo transportista.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'nss' => 'required|string|max:255',
            'foto_licencia' => 'required|string|max:255',
            'comprobante_domicilio' => 'required|string|max:255',
            'foto_identificacion' => 'required|string|max:255',
            'rfc' => 'required|string|max:255',
            'carta_de_no_antecedentes' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'tipo_licencia_id' => 'required|exists:tipo_de_licencia,id',
        ]);

        $transportista = UserTrasportista::create($validated);
        return response()->json(['message' => 'Transportista creado exitosamente.', 'data' => $transportista], 201);
    }

    /**
     * Mostrar un transportista específico.
     */
    public function show($id)
    {
        $transportista = UserTrasportista::find($id);

        if (!$transportista) {
            return response()->json(['message' => 'Transportista no encontrado.'], 404);
        }

        return response()->json($transportista);
    }

    /**
     * Actualizar un transportista existente.
     */
    public function update(Request $request, $id)
    {
        $transportista = UserTrasportista::find($id);

        if (!$transportista) {
            return response()->json(['message' => 'Transportista no encontrado.'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'nss' => 'required|string|max:255',
            'foto_licencia' => 'required|string|max:255',
            'comprobante_domicilio' => 'required|string|max:255',
            'foto_identificacion' => 'required|string|max:255',
            'rfc' => 'required|string|max:255',
            'carta_de_no_antecedentes' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'tipo_licencia_id' => 'required|exists:tipo_de_licencia,id',
        ]);

        $transportista->update($validated);
        return response()->json(['message' => 'Transportista actualizado exitosamente.', 'data' => $transportista]);
    }

    /**
     * Eliminar un transportista.
     */
    public function destroy($id)
    {
        $transportista = UserTrasportista::find($id);

        if (!$transportista) {
            return response()->json(['message' => 'Transportista no encontrado.'], 404);
        }

        $transportista->delete();
        return response()->json(['message' => 'Transportista eliminado exitosamente.']);
    }
}
