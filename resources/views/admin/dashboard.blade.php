<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Admin - Carga Loop</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <x-navbar />

  <div class="p-8">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-4xl font-bold text-gray-900">Panel de Administrador</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <div class="text-4xl text-blue-700">{{ count($nuevosUsuarios ?? []) }}</div>
        <div class="text-gray-600">Usuarios Nuevos</div>
           <a href="{{ route('usuarios') }}"
     class="mt-4 inline-block text-sm text-blue-700 hover:underline">
    Ver detalles
  </a>
      </div>
    
      <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <div class="text-4xl text-purple-700">{{ count($repartidores ?? []) }}</div>
        <div class="text-gray-600">Repartidores</div>
         <a href="{{ route('repartidores') }}"
     class="mt-4 inline-block text-sm text-blue-700 hover:underline">
    Ver detalles
  </a>
      </div>
       <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <div class="text-4xl text-purple-700">{{ count($empresas ?? []) }}</div>
        <div class="text-gray-600">Empresas </div>
         <a href="{{ route('empresas') }}"
     class="mt-4 inline-block text-sm text-blue-700 hover:underline">
    Ver detalles
  </a>
      </div>




    </div>
    

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      {{-- Usuarios Nuevos --}}
      <div>
        <h2 class="text-xl font-semibold mb-4">Usuarios Nuevos</h2>
        <ul class="bg-white rounded shadow divide-y divide-gray-200">
            @forelse ($nuevosUsuarios ?? [] as $usuario)
            <li class="p-4">{{ $usuario->name }} — {{ $usuario->email }}</li>
          @empty
            <li class="p-4 text-gray-500">Sin usuarios nuevos.</li>
          @endforelse
        </ul>
      </div>

    

      {{-- Repartidores --}}
      <div>
        <h2 class="text-xl font-semibold mb-4">Repartidores</h2>
        <ul class="bg-white rounded shadow divide-y divide-gray-200">
          @forelse ($repartidores ?? [] as $rep)
            <li class="p-4">{{ $rep->name }} — {{ $rep->phone }}</li>
          @empty
            <li class="p-4 text-gray-500">Sin repartidores registrados.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>



  <script>
    function openModal() {
      document.getElementById('invitationModal').classList.remove('hidden');
    }
  </script>
</body>
</html>
