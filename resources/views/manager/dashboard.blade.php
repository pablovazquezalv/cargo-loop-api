<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carga Loop</title>
  <meta property="og:title" content="Carga Loop - Plataforma de Traslado de Carga" />
  <meta property="og:description" content="Conecta con generadores de carga y optimiza tus envíos con Carga Loop. Somos expertos en logística con más de 20 años de experiencia." />
  <meta property="og:image" content="https://www.mx.cargo-loop.com/Carga-loop-og.png" />
  <meta property="og:url" content="https://www.mx.cargo-loop.com" />
  <meta property="og:type" content="website" />

  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .fade-in { opacity: 0; transform: translateY(-30px); animation: fadeIn 0.8s ease-out forwards; }
    .fade-delay-1 { animation-delay: 0.4s; }
    .fade-delay-2 { animation-delay: 0.6s; }
    .zoom-in { transform: scale(0.8); animation: zoomIn 0.8s ease-out forwards; animation-delay: 0.8s; }

    @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
    @keyframes zoomIn { to { opacity: 1; transform: scale(1); } }
  </style>
</head>
<body class="bg-gray-100">

  <x-navbar />

  <div class="p-4 sm:p-8 bg-gray-100 min-h-screen pb-20">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
      <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Hola Manager</h1>
      <div class="flex gap-2">
        <button class="bg-blue-800 text-white px-4 py-2 rounded" onclick="openModal()">Invitar a transportista</button>
        {{-- <button class="bg-green-600 text-white px-4 py-2 rounded" onclick="openPedidoModal()">Crear Pedido</button> --}}
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      @foreach([
        ['value' => $dashboardData['transportistas'] ?? 0, 'label' => 'Transportistas', 'icon' => '👤'],
        ['value' => $dashboardData['cargas'] ?? 0, 'label' => 'Cargas', 'icon' => '📦'],
      ] as $item)
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
          <div class="text-4xl mb-2">{{ $item['value'] }}</div>
          <div class="text-5xl mb-2">{{ $item['icon'] }}</div>
          <div class="text-gray-500">{{ $item['label'] }}</div>
        </div>
      @endforeach

      @if($company)
        <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-white shadow-md rounded-lg p-6 flex flex-col sm:flex-row items-center sm:space-x-6 space-y-4 sm:space-y-0 mt-4">
          @if($company->profile_picture)
            <img src="{{ asset('storage/' . $company->profile_picture) }}" alt="Logo" class="w-24 h-24 object-cover rounded-full" />
          @else
            <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center text-xl font-bold text-white">
              {{ strtoupper(substr($company->name, 0, 1)) }}
            </div>
          @endif
          <div>
            <h2 class="text-2xl font-bold text-gray-800">Mi Empresa: {{ $company->name }}</h2>
            @if($company->business_name)
              <p class="text-gray-500">{{ $company->business_name }}</p>
            @endif
            <p class="text-gray-700">{{ $company->email }}</p>
            <p class="text-gray-700">{{ $company->phone }}</p>
            <p class="text-gray-700">{{ $company->address }}, {{ $company->city }}, {{ $company->state }}, {{ $company->country }} - {{ $company->postal_code }}</p>
            @if($company->website)
              <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $company->website }}</a>
            @endif
            @if($company->description)
              <p class="mt-2 text-gray-600 italic">{{ $company->description }}</p>
            @endif
          </div>
        </div>
      @endif
    </div>
  </div>

  {{-- Modal de Invitación --}}
  <div id="invitationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
      <h2 class="text-xl font-bold mb-4">Invitar a transportista</h2>
      <form method="POST" action="{{ route('invite') }}">
        @csrf
        <input type="email" name="email" required class="w-full border rounded p-2 mb-4" placeholder="Correo electrónico" />
        <button type="submit" class="bg-blue-800 text-white px-4 py-2 rounded w-full">Enviar invitación</button>
      </form>
      <button class="mt-4 text-sm text-gray-500 w-full" onclick="document.getElementById('invitationModal').classList.add('hidden')">Cancelar</button>
    </div>
  </div>

<!-- Modal de Pedido -->
<div id="pedidoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-3xl max-h-[90vh] overflow-y-auto mx-4 animate-fade-in">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">📦 Crear Nuevo Pedido</h2>

    <form method="POST" action="{{ url('api/pedido/crear') }}" class="space-y-4 text-gray-700">
      @csrf

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="font-semibold">Fecha de carga</label>
          <input type="date" name="fecha_carga" required class="w-full border rounded-lg p-2 mt-1" />
        </div>

        <div>
          <label class="font-semibold">Valor de carga</label>
          <input type="number" step="0.01" name="valor_carga" class="w-full border rounded-lg p-2 mt-1" />
        </div>
      </div>

      <div>
        <label class="font-semibold">Descripción de carga</label>
        <input type="text" name="descripcion_carga" required class="w-full border rounded-lg p-2 mt-1" />
      </div>

      <div>
        <label class="font-semibold">Especificación de carga</label>
        <input type="text" name="especificacion_carga" class="w-full border rounded-lg p-2 mt-1" />
      </div>

      <div class="flex items-center space-x-2">
        <input type="checkbox" name="aplica_seguro" value="1" class="rounded" />
        <label class="font-semibold">¿Aplica seguro?</label>
      </div>

      <div>
        <label class="font-semibold">Observaciones</label>
        <textarea name="observaciones" rows="2" class="w-full border rounded-lg p-2 mt-1"></textarea>
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="font-semibold">Tipo de vehículo</label>
          <input type="text" name="tipo_De_vehiculo" class="w-full border rounded-lg p-2 mt-1" />
        </div>

        <div>
          <label class="font-semibold">Seguro de carga</label>
          <input type="text" name="seguro_carga" class="w-full border rounded-lg p-2 mt-1" />
        </div>

        <div>
          <label class="font-semibold">Carta porte</label>
          <input type="text" name="cartaporte" class="w-full border rounded-lg p-2 mt-1" />
        </div>
<!-- 
        <div>
          <label class="font-semibold">Estado del pedido</label>
          <select name="estado_pedido" class="w-full border rounded-lg p-2 mt-1">
            <option value="pendiente">Pendiente</option>
            <option value="en_proceso">En proceso</option>
            <option value="entregado">Entregado</option>
          </select>
        </div>
      </div> -->

      <input type="hidden" name="estado_pedido" value="pendiente">
      <input type="hidden" name="cliente_id" value="{{ auth()->user()->id }}">


      <!-- <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="font-semibold">ID Compañía</label>
          <input type="number" name="id_company" required class="w-full border rounded-lg p-2 mt-1" />
        </div>

        <div>
          <label class="font-semibold">ID Cliente</label>
          <input type="number" name="cliente_id" required class="w-full border rounded-lg p-2 mt-1" />
        </div>
      </div> -->

      <div class="mt-6 border-t pt-4">
        <h4 class="text-lg font-bold mb-2">📍 Ubicación de recolección</h4>
        <div class="grid sm:grid-cols-3 gap-4">
          <div>
            <label class="font-semibold">Latitud</label>
            <input type="text" name="ubicacion_recoger_lat" required class="w-full border rounded-lg p-2 mt-1" />
          </div>
          <div>
            <label class="font-semibold">Longitud</label>
            <input type="text" name="ubicacion_recoger_long" required class="w-full border rounded-lg p-2 mt-1" />
          </div>
          <div class="sm:col-span-3">
            <label class="font-semibold">Descripción</label>
            <input type="text" name="ubicacion_recoger_descripcion" required class="w-full border rounded-lg p-2 mt-1" />
          </div>
        </div>
      </div>

      <div class="mt-6 border-t pt-4">
        <h4 class="text-lg font-bold mb-2">🚚 Ubicación de entrega</h4>
        <div class="grid sm:grid-cols-3 gap-4">
          <div class="sm:col-span-3">
            <label class="font-semibold">Dirección</label>
            <input type="text" name="ubicacion_entregar_direccion" class="w-full border rounded-lg p-2 mt-1" />
          </div>
          <div>
            <label class="font-semibold">Latitud</label>
            <input type="text" name="ubicacion_entregar_lat" required class="w-full border rounded-lg p-2 mt-1" />
          </div>
          <div>
            <label class="font-semibold">Longitud</label>
            <input type="text" name="ubicacion_entregar_long" required class="w-full border rounded-lg p-2 mt-1" />
          </div>
        </div>
      </div>

      <div class="grid sm:grid-cols-3 gap-4 mt-6">
        <div>
          <label class="font-semibold">Cantidad</label>
          <input type="number" name="cantidad" required class="w-full border rounded-lg p-2 mt-1" />
        </div>

        <div>
          <label class="font-semibold">Tipo de material</label>
          <input type="text" name="tipo_de_material" class="w-full border rounded-lg p-2 mt-1" />
        </div>

        <div>
          <label class="font-semibold">Tipo de pago</label>
          <input type="text" name="tipo_de_pago" class="w-full border rounded-lg p-2 mt-1" />
        </div>
      </div>

      <div>
        <label class="font-semibold">Nombre del contacto</label>
        <input type="text" name="nombre_contacto" class="w-full border rounded-lg p-2 mt-1" />
      </div>

      <div class="flex flex-col sm:flex-row justify-between gap-4 mt-6">
        <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold">
          💾 Guardar pedido
        </button>
        <button type="button" class="w-full sm:w-auto text-gray-500 hover:text-gray-700 font-medium" onclick="closePedidoModal()">
          Cancelar
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Animación opcional -->
<style>
  @keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in {
    animation: fade-in 0.4s ease-out;
  }
</style>


  <script>
    function openModal() {
      document.getElementById('invitationModal').classList.remove('hidden');
    }
    function openPedidoModal() {
      document.getElementById('pedidoModal').classList.remove('hidden');
    }
    function closePedidoModal() {
      document.getElementById('pedidoModal').classList.add('hidden');
    }
  </script>
</body>
</html>
