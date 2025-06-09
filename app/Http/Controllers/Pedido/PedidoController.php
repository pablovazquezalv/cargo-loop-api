<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedido\pedidos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Trasportista\Dealer;


class PedidoController extends Controller
{
    //
    public function crearPedido(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|integer',
            'company_id' => 'required|integer',
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer',
            'precio' => 'required|integer',
            'total' => 'required|integer',
            'estado' => 'required|integer',
            'fecha' => 'required|date',
            'hora' => 'required|date',
            'direccion' => 'required|string',
            'latitud' => 'required|string',
            'longitud' => 'required|string',
            'observaciones' => 'required|string',
            'tipo_pago' => 'required|integer',
            'tipo_envio' => 'required|integer',
            'tipo_pedido' => 'required|integer',
            'tipo_producto' => 'required|integer',
            'tipo_empresa' => 'required|integer',
            'tipo_cliente' => 'required|integer',
            'tipo_dealer' => 'required|integer',
            'tipo_company' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        // 🔍 Buscar dealer disponible para la compañía
        $dealerDisponible = Dealer::where('company_id', $request->company_id)
                                ->where('estado', 'disponible') // Ajusta según tu modelo
                                ->first();
    
        if (!$dealerDisponible) {
            return response()->json(['error' => 'No hay dealers disponibles en este momento'], 409);
        }
    
        // 📦 Crear el pedido y asignar el dealer automáticamente
        $pedido = new pedidos();
        $pedido->cliente_id = $request->cliente_id;
        $pedido->dealer_id = $dealerDisponible->id;
        $pedido->company_id = $request->company_id;
        $pedido->producto_id = $request->producto_id;
        $pedido->cantidad = $request->cantidad;
        $pedido->precio = $request->precio;
        $pedido->total = $request->total;
        $pedido->estado = $request->estado;
        $pedido->fecha = $request->fecha;
        $pedido->hora = $request->hora;
        $pedido->direccion = $request->direccion;
        $pedido->latitud = $request->latitud;
        $pedido->longitud = $request->longitud;
        $pedido->observaciones = $request->observaciones;
        $pedido->tipo_pago = $request->tipo_pago;
        $pedido->tipo_envio = $request->tipo_envio;
        $pedido->tipo_pedido = $request->tipo_pedido;
        $pedido->tipo_producto = $request->tipo_producto;
        $pedido->tipo_empresa = $request->tipo_empresa;
        $pedido->tipo_cliente = $request->tipo_cliente;
        $pedido->tipo_dealer = $request->tipo_dealer;
        $pedido->tipo_company = $request->tipo_company;
    
        if ($pedido->save()) {
            // Actualizar el estado del dealer a ocupado
            $dealerDisponible->estado = 'ocupado';
            $dealerDisponible->save();
    
            return response()->json([
                'message' => 'Pedido creado y asignado correctamente',
                'pedido_id' => $pedido->id,
                'dealer_id' => $dealerDisponible->id
            ], 200);
        } else {
            return response()->json(['message' => 'Error al crear el pedido'], 500);
        }
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
