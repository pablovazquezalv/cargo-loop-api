<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedido\pedidos;
use App\Models\pedidoTrasportista\pedidoTrasportista;
use Illuminate\Support\Facades\Validator;
use App\Models\Trasportista\Dealer;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function crearPedido(Request $request)
    {
        // ✅ Validación
        $validator = Validator::make($request->all(), [
             'fecha_carga' => 'required|date',
            // 'lugar_origen' => 'required|string',
            // 'lugar_destino' => 'required|string',
            //  'tipo_unidad' => 'required|string',
            
             'descripcion_carga' => 'nullable|string',
             'especificacion_carga' => 'nullable|string',
            
             'valor_carga' => 'required|numeric',
             'aplica_seguro' => 'boolean',
             'observaciones' => 'nullable|string',
              'tipo_De_vehiculo' =>'required|string',
             'seguro_carga' => 'nullable|string',
             'cartaporte' => 'nullable|string',
             'estado_pedido' => 'nullable|string',
             'id_company' => 'required|integer',
             'cliente_id' =>'required|integer',
             'ubicacion_recoger_lat' => 'required|numeric',
             'ubicacion_recoger_long' => 'required|numeric',
             'ubicacion_recoger_descripcion' => 'required|string',
             'ubicacion_entregar_direccion' =>'required|string',
             'ubicacion_entregar_lat' => 'required|numeric',
             'ubicacion_entregar_long' => 'required|numeric',
             'cantidad' => 'required|integer',
             'tipo_de_material' => 'required|string',
             'tipo_de_pago' =>'required|string',
             'nombre_contacto' =>'required|string'

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // 🔍 Buscar repartidor disponible (dealer)
        // $dealer = Dealer::where('company_id', $request->input('company_id', 1)) // Puedes cambiar esto
        //                 ->where('estado', 'disponible')
        //                 ->first();

        // if (!$dealer) {
        //     return response()->json(['error' => 'No hay repartidores disponibles en este momento'], 409);
        // }

        // 📦 Crear el pedido
        $pedido = new pedidos();
        $pedido->nombre_contacto = $request->nombre_contacto;
        $pedido->tipo_de_pago = $request->tipo_de_pago;
         $pedido->fecha_carga = $request->fecha_carga;
        //  $pedido->tipo_unidad = $request->tipo_unidad;
         $pedido->cantidad = $request->cantidad;
         $pedido->tipo_de_material = $request->tipo_de_material;
         $pedido->descripcion_carga = $request->descripcion_carga;
         $pedido->valor_carga = $request->valor_carga;
         $pedido->aplica_seguro = $request->aplica_seguro ?? false;
         $pedido->especificacion_carga = $request->especificacion_carga;
         $pedido->observaciones = $request->observaciones;
         $pedido->seguro_carga = $request->seguro_carga;
         $pedido->cartaporte = $request->cartaporte;
         $pedido->estado_pedido = 'disponible';
         $pedido->id_company = $request->id_company;
         $pedido->cliente_id = $request->cliente_id;
         $pedido->tipo_de_vehiculo = $request->tipo_De_vehiculo;
         $pedido->ubicacion_recoger_lat = $request->ubicacion_recoger_lat;
         $pedido->ubicacion_recoger_long = $request->ubicacion_recoger_long;
         $pedido->ubicacion_recoger_descripcion = $request->ubicacion_recoger_descripcion;
         $pedido->ubicacion_entregar_lat = $request->ubicacion_entregar_lat;
         $pedido->ubicacion_entregar_long = $request->ubicacion_entregar_long;
         $pedido->ubicacion_entregar_direccion = $request->ubicacion_entregar_direccion;

    

        if ($pedido->save()) {
            // $dealer->estado = 'ocupado';
            // $dealer->save();

            return response()->json([
                'message' => 'Pedido creado exitosamente',
                'pedido_id' => $pedido->id,
                // 'dealer_id' => $dealer->id
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






    public function aceptarPedido($pedido_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        // Buscar el pedido
        $pedido = pedidos::find($pedido_id);
       
        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }


    
        // Actualizar el estado del pedido
        $pedido->id_repartidor = $request->id_user;
        $pedido->estado_pedido = 'aceptado';
        $pedido->save();
        $pedidoTrasportista = DB::table('pedido_transportista')->insert([
            'pedido_id' => $pedido_id,
            'transportista_id' => $request->id_user,
            'estado_asignacion' => 'aceptado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if (!$pedidoTrasportista) {
            return response()->json(['error' => 'No se pudo crear el pedido'], 500);
        }
       
    
        return response()->json(['message' => 'Pedido aceptado','Pedido'=>$pedido], 200);
    }
    



    public function pedidosDisponibles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_company' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        $pedidos = pedidos::where('estado_pedido', 'disponible')
            ->where('id_company', $request->id_company)
            ->first();
    
        return response()->json($pedidos);
    }
    

    public function pedidosFinalizadosporTransportista($id_user){
        $pedidos = pedidos::where('id_repartidor', $id_user)
        ->where('estado_pedido', 'finalizado')
        ->get();
        return response()->json($pedidos);
    }

    public function pedidosporTrasposrtista($id_user){
        $pedidos = pedidos::where('id_repartidor', $id_user)
        ->where('estado_pedido', 'finalizado')
        ->get();
        return response()->json($pedidos);
    }
    
    public function pedidosCanceladosporTransportista($id_user){
        // $pedidos = pedidos::where('id_repartidor', $id_user)
        // ->where('estado_pedido', 'cancelado')
        // ->get();
        $pedidos = DB::table('pedido_trasportista')
        ->join('pedidos', 'pedido_trasportista.id_pedido', '=', 'pedidos.id')
        ->where('pedido_trasportista.id_user', $id_user)
        ->where('pedido_trasportista.estado', 'cancelado')
        ->select('pedidos.*')
        ->get();
        return response()->json($pedidos);
    }

    /**
     * Finalizar un pedido
     *
     * @param int $pedido_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

        public function pedidoenProceso($pedido_id, Request $request)
        {
            $validator = Validator::make($request->all(), [
                'id_user' => 'required|integer'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            // Buscar el pedido
            $pedido = pedidos::find($pedido_id);

            if (!$pedido) {
                return response()->json(['error' => 'Pedido no encontrado'], 404);
            }

            // Actualizar el estado del pedido
            $pedido->estado_pedido = 'en_proceso';
            $pedido->save();

            return response()->json(['message' => 'Pedido en proceso'], 200);
        }

  public function finalizarPedido($pedido_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' =>'required|integer',
            'fotos_de_mercancia' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'fotos_de_mercancia_1'=> 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'fotos_de_mercancia_2'=>'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'fotos_de_mercancia_3'=>'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'fotos_de_mercancia_4'=>'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        // Buscar el pedido
        $pedido = pedidos::find($pedido_id);
        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }
        // Verificar si el pedido ya ha sido finalizado
        $pedidoFinalizado = pedidoTrasportista::where('id_pedido', $pedido_id)->first();
        $pedido->estado_pedido = 'finalizado';
        $pedido->save();
        if ($pedidoFinalizado) {
            $pedidoTrasportista = pedidoTrasportista::find($pedidoFinalizado->id);
            $pedidoTrasportista->estado = 'finalizado';
            $pedidoTrasportista->fotos_de_mercancia = $request->fotos_de_mercancia->store('fotos_de_mercancia');
            $pedidoTrasportista->fotos_de_mercancia_1 = $request->fotos_de_mercancia_1->store('fotos_de_mercancia');
            $pedidoTrasportista->fotos_de_mercancia_2 = $request->fotos_de_mercancia_2->store('fotos_de_mercancia');
            $pedidoTrasportista->fotos_de_mercancia_3 = $request->fotos_de_mercancia_3->store('fotos_de_mercancia');
            $pedidoTrasportista->fotos_de_mercancia_4 = $request->fotos_de_mercancia_4->store('fotos_de_mercancia');
            $pedidoTrasportista->save();
            return response()->json(['message' => 'Pedido finalizado'], 200);
        } else {
            return response()->json(['error' => 'No se pudo finalizar el pedido'], 500);
        }
    }
}
