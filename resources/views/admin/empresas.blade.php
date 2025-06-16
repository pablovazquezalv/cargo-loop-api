<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Empresas - Carga Loop</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head><body class="bg-gray-50 min-h-screen">

  <x-navbar />

  <div class="container mx-auto px-4">
    <br>
    <h1 class="text-3xl font-bold text-blue-800 mb-8">Empresas Registradas</h1>

    <div class="mb-4">
      <a href="{{ route('dashboard-admin') }}" class="text-blue-600 hover:underline">Regresar al Dashboard</a>
    </div>

    @if($empresas->isEmpty())
      <p class="text-gray-600">No hay empresas registradas.</p>
    @else
      <div class="overflow-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
          <thead class="bg-blue-800 text-white">
            <tr>
              <th class="py-3 px-4 text-left">Nombre</th>
              <th class="py-3 px-4 text-left">Razón Social</th>
              <th class="py-3 px-4 text-left">Correo</th>
              <th class="py-3 px-4 text-left">Teléfono</th>
              <th class="py-3 px-4 text-left">Dirección</th>
              <th class="py-3 px-4 text-left">Ciudad</th>
              <th class="py-3 px-4 text-left">Estado</th>
              <th class="py-3 px-4 text-left">País</th>
              <th class="py-3 px-4 text-left">C.P.</th>
              <th class="py-3 px-4 text-left">Sitio Web</th>
              <th class="py-3 px-4 text-left">Descripción</th>
              <th class="py-3 px-4 text-left">Logo</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            @foreach ($empresas as $empresa)
              <tr class="border-b">
                <td class="py-3 px-4">{{ $empresa->name }}</td>
                <td class="py-3 px-4">{{ $empresa->business_name ?? '-' }}</td>
                <td class="py-3 px-4">{{ $empresa->email }}</td>
                <td class="py-3 px-4">{{ $empresa->phone ?? '-' }}</td>
                <td class="py-3 px-4">{{ $empresa->address ?? '-' }}</td>
                <td class="py-3 px-4">{{ $empresa->city ?? '-' }}</td>
                <td class="py-3 px-4">{{ $empresa->state ?? '-' }}</td>
                <td class="py-3 px-4">{{ $empresa->country ?? '-' }}</td>
                <td class="py-3 px-4">{{ $empresa->postal_code ?? '-' }}</td>
                <td class="py-3 px-4">
                  @if($empresa->website)
                    <a href="{{ $empresa->website }}" class="text-blue-600 hover:underline" target="_blank">{{ $empresa->website }}</a>
                  @else
                    -
                  @endif
                </td>
                <td class="py-3 px-4">{{ $empresa->description ?? '-' }}</td>
                <td class="py-3 px-4">
                  @if($empresa->profile_picture)
                    <img src="{{ asset('storage/' . $empresa->profile_picture) }}" class="w-16 h-16 rounded shadow object-cover" alt="Logo">
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
  </div>

</body>
