<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clientes - Carga Loop</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

  <x-navbar />

  <br>
  <h1 class="text-3xl font-bold text-blue-800 mb-8 ml-2">Clientes Registrados</h1>

  <div class="mb-4 ml-2">
    <a href="{{ route('dashboard-admin') }}" class="text-blue-600 hover:underline">Regresar al Dashboard</a>
  </div>

  @if($clientes->isEmpty())
    <p class="text-gray-600 ml-2">No hay clientes registrados.</p>
  @else
    <div class="overflow-auto">
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-blue-800 text-white">
          <tr>
            <th class="py-3 px-4 text-left">Nombre</th>
            <th class="py-3 px-4 text-left">Correo</th>
            <th class="py-3 px-4 text-left">Teléfono</th>
            <th class="py-3 px-4 text-left">Dirección</th>
            <th class="py-3 px-4 text-left">Ciudad</th>
            <th class="py-3 px-4 text-left">Estado</th>
            <th class="py-3 px-4 text-left">País</th>
            <th class="py-3 px-4 text-left">C.P.</th>
            <th class="py-3 px-4 text-left">Status</th>
            <th class="py-3 px-4 text-left">Acciones</th>
            <th class="py-3 px-4 text-left">Independiente</th>
            <th class="py-3 px-4 text-left">InCompany</th>
            <th class="py-3 px-4 text-left">Foto</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          @foreach ($clientes as $cliente)
            <tr class="border-b">
              <td class="py-3 px-4">{{ $cliente->name }}</td>
              <td class="py-3 px-4">{{ $cliente->email }}</td>
              <td class="py-3 px-4">{{ $cliente->phone ?? '-' }}</td>
              <td class="py-3 px-4">{{ $cliente->address ?? '-' }}</td>
              <td class="py-3 px-4">{{ $cliente->city ?? '-' }}</td>
              <td class="py-3 px-4">{{ $cliente->state ?? '-' }}</td>
              <td class="py-3 px-4">{{ $cliente->country ?? '-' }}</td>
              <td class="py-3 px-4">{{ $cliente->postal_code ?? '-' }}</td>
              <td class="py-3 px-4">
                @if($cliente->status == 1)
                  <span class="text-green-600 font-semibold">Activo</span>
                @else
                  <span class="text-red-600 font-semibold">Inactivo</span>
                @endif
              </td>
               <td class="py-3 px-4">
        <form action="{{ route('clientes.toggleStatus', $cliente->id) }}" method="POST">
          @csrf
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded">
            {{ $cliente->status ? 'Desactivar' : 'Activar' }}
          </button>
        </form>
      </td>
              <td class="py-3 px-4">
                {{ $cliente->independiente ? 'Sí' : 'No' }}
              </td>
              <td class="py-3 px-4">
                {{ $cliente->incompany ? 'Sí' : 'No' }}
              </td>
              
              <td class="py-3 px-4">
                @if($cliente->profile_picture)
                  <img src="{{ asset('storage/' . $cliente->profile_picture) }}" class="w-16 h-16 rounded shadow object-cover" alt="Foto">
                @else
                  -
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

</body>
</html>
