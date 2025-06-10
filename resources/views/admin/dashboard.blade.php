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
      <button class="bg-blue-800 text-white px-4 py-2 rounded" onclick="openModal()">Invitar a transportista</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <div class="text-4xl text-blue-700">{{ count($nuevosUsuarios ?? []) }}</div>
        <div class="text-gray-600">Usuarios Nuevos</div>
      </div>
      <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <div class="text-4xl text-green-700">{{ count($invitaciones ?? []) }}</div>
        <div class="text-gray-600">Invitaciones Enviadas</div>
      </div>
      <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <div class="text-4xl text-purple-700">{{ count($repartidores ?? []) }}</div>
        <div class="text-gray-600">Repartidores</div>
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

      {{-- Invitaciones --}}
      <div>
        <h2 class="text-xl font-semibold mb-4">Invitaciones</h2>
        <ul class="bg-white rounded shadow divide-y divide-gray-200">
          @forelse ($invitaciones ?? [] as $inv)
            <li class="p-4">
              {{ $inv->email }} — <span class="text-sm text-gray-500">Enviada: {{ $inv->created_at->format('d/m/Y') }}</span>
            </li>
          @empty
            <li class="p-4 text-gray-500">No hay invitaciones aún.</li>
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

  {{-- Modal de invitación --}}
  <div id="invitationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Invitar a transportista</h2>
      <form method="POST" action="{{ route('invite') }}">
        @csrf
        <input type="email" name="email" required class="w-full border rounded p-2 mb-4" placeholder="Correo electrónico">
        <button type="submit" class="bg-blue-800 text-white px-4 py-2 rounded">Enviar invitación</button>
      </form>
      <button class="mt-4 text-sm text-gray-500" onclick="document.getElementById('invitationModal').classList.add('hidden')">Cancelar</button>
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById('invitationModal').classList.remove('hidden');
    }
  </script>
</body>
</html>
