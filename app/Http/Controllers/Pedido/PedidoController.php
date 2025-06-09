<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedido\pedidos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PedidoController extends Controller
{
    //
    public function crearPedido(Request $request){

        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|integer',
            'dealer_id' => 'required|integer',
            'company_id' => 'required|integer',
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer',
            'precio' =>'required|integer',
            'total' =>'required|integer',
            'estado' =>'required|integer',
            'fecha' =>'required|date',
            'hora' =>'required|date',
            'direccion' =>'required|string',
            'latitud' =>'required|string',
            'longitud' =>'required|string',
            'observaciones' =>'required|string',
            'tipo_pago' =>'required|integer',
            'tipo_envio' =>'required|integer',
            'tipo_pedido' =>'required|integer',
            'tipo_producto' =>'required|integer',
            'tipo_empresa' =>'required|integer',
            'tipo_cliente' =>'required|integer',
            'tipo_dealer' =>'required|integer',
            'tipo_company' =>'required|integer',
            'tipo_producto' =>'required|integer',
            'tipo_empresa' =>'required|integer',
            'tipo_cliente' =>'required|integer',
            'tipo_dealer' =>'required|integer',
            'tipo_company' =>'required|integer',
            'tipo_producto' =>'required|integer',
            'tipo_empresa' =>'required|integer',
            'tipo_cliente' =>'required|integer',
            'tipo_dealer' =>'required|integer',     
        ])
        ;
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $pedido = new pedidos();
        $pedido->cliente_id = $request->cliente_id;
        $pedido->dealer_id = $request->dealer_id;
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
        $pedido->tipo_producto = $request->tipo_producto;
        $pedido->tipo_empresa = $request->tipo_empresa;
        $pedido->tipo_cliente = $request->tipo_cliente;

        if ($pedido->save()) {
            return response()->json(['message' => 'Pedido creado correctamente'], 200);
        } else {
            return response()->json(['message' => 'Error al crear el pedido'], 401);
        }
    }
}
