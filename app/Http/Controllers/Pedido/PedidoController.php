<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedido\pedidos;
use Illuminate\Support\Facades\Validator;
use App\Models\Trasportista\Dealer;

class PedidoController extends Controller
{
    public function crearPedido(Request $request)
    {
        // ✅ Validación
        $validator = Validator::make($request->all(), [
            'fecha_carga' => 'required|date',
            'lugar_origen' => 'required|string',
            'lugar_destino' => 'required|string',
            'tipo_unidad' => 'required|string',
            'tipo_carga' => 'required|string',
            'descripcion_carga' => 'nullable|string',
            'especificacion_carga' => 'nullable|string',
            'nombre_contacto' => 'required|string',
            'valor_carga' => 'required|numeric',
            'aplica_seguro' => 'boolean',
            'observaciones' => 'nullable|string',
            'tipo_industria' => 'nullable|string',
            'requerimiento_carga' => 'nullable|string',
            'seguro_carga' => 'nullable|string',
            'cartaporte' => 'nullable|string',
            'estado_pedido' => 'nullable|string',
            'id_company' => 'required|integer',
            'cliente_id' =>'required|integer'

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // 🔍 Buscar repartidor disponible (dealer)
        $dealer = Dealer::where('company_id', $request->input('company_id', 1)) // Puedes cambiar esto
                        ->where('estado', 'disponible')
                        ->first();

        if (!$dealer) {
            return response()->json(['error' => 'No hay repartidores disponibles en este momento'], 409);
        }

        // 📦 Crear el pedido
        $pedido = new pedidos();
        $pedido->fecha_carga = $request->fecha_carga;
        $pedido->lugar_origen = $request->lugar_origen;
        $pedido->lugar_destino = $request->lugar_destino;
        $pedido->tipo_unidad = $request->tipo_unidad;
        $pedido->tipo_carga = $request->tipo_carga;
        $pedido->descripcion_carga = $request->descripcion_carga;
        $pedido->especificacion_carga = $request->especificacion_carga;
        $pedido->nombre_contacto = $request->nombre_contacto;
        $pedido->valor_carga = $request->valor_carga;
        $pedido->aplica_seguro = $request->aplica_seguro ?? false;
        $pedido->observaciones = $request->observaciones;
        $pedido->tipo_industria = $request->tipo_industria;
        $pedido->requerimiento_carga = $request->requerimiento_carga;
        $pedido->seguro_carga = $request->seguro_carga;
        $pedido->cartaporte = $request->cartaporte;
        $pedido->estado_pedido = $request->estado_pedido ?? 'pendiente';
        $pedido->id_company = $request->id_company;
        $pedido->cliente_id = $request->cliente_id;
    

        if ($pedido->save()) {
            $dealer->estado = 'ocupado';
            $dealer->save();

            return response()->json([
                'message' => 'Pedido creado exitosamente',
                'pedido_id' => $pedido->id,
                'dealer_id' => $dealer->id
            ], 201);
        }

        return response()->json(['error' => 'No se pudo crear el pedido'], 500);
    }

    public function listarPedidos()
    {
        $pedidos = pedidos::all();
        return response()->json($pedidos);
    }

    public function listarPedidosPorCliente($cliente_id)
    {
        $pedidos = pedidos::where('cliente_id', $cliente_id)->get();
        return response()->json($pedidos);
    }
}
