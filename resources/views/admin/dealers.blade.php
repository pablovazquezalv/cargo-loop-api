<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Repartidores - Carga Loop</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

  <x-navbar />
<br>
  <h1 class="text-3xl font-bold text-blue-800 mb-8 ml-2">Repartidores Registrados</h1>

<!-- boton de regresar al dasnhboard-->
    <div class="mb-4 ml-2">
        <a href="{{ route('dashboard-admin') }}" class="text-blue-600 hover:underline">Regresar al Dashboard</a>
    </div>
  
  @if($repartidores->isEmpty())
    <p class="text-gray-600">No hay repartidores registrados.</p>
  @else
    <div class="overflow-auto">
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-blue-800 text-white">
          <tr>
            <th class="py-3 px-4 text-left">Nombre</th>
            <th class="py-3 px-4 text-left">Correo</th>
            <th class="py-3 px-4 text-left">Teléfono</th>
            <th class="py-3 px-4 text-left">Ciudad</th>
            <th class="py-3 px-4 text-left">Tipo Licencia</th>
            <th class="py-3 px-4 text-left">RFC</th>
            <th class="py-3 px-4 text-left">NSS</th>
            <th class="py-3 px-4 text-left">Status</th>
            <th class="py-3 px-4 text-left">Licencia</th>
            <th class="py-3 px-4 text-left">Domicilio</th>
            <th class="py-3 px-4 text-left">Identificación</th>
            <th class="py-3 px-4 text-left">No Penales</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          @foreach ($repartidores as $rep)
            <tr class="border-b">
              <td class="py-3 px-4">{{ $rep->name }}</td>
              <td class="py-3 px-4">{{ $rep->email }}</td>
              <td class="py-3 px-4">{{ $rep->phone }}</td>
              <td class="py-3 px-4">{{ $rep->city ?? '-' }}</td>
              <td class="py-3 px-4">{{ $rep->type_license ?? '-' }}</td>
              <td class="py-3 px-4">{{ $rep->rfc ?? '-' }}</td>
              <td class="py-3 px-4">{{ $rep->nss ?? '-' }}</td>
              <td class="py-3 px-4">
                @if($rep->status === 1)
                  <span class="text-green-600 font-semibold">Activo</span>
                @else
                  <span class="text-red-600 font-semibold">Inactivo</span>
                @endif
              </td>
              <td class="py-3 px-4">
                @if($rep->picture_license)
                  <img src="{{ asset('storage/' . $rep->picture_license) }}" class="w-16 h-16 rounded shadow object-cover" alt="Licencia">
                @else
                  -
                @endif
              </td>
              <td class="py-3 px-4">
                @if($rep->proof_of_residence)
                  <img src="{{ asset('storage/' . $rep->proof_of_residence) }}" class="w-16 h-16 rounded shadow object-cover" alt="Comprobante">
                @else
                  -
                @endif
              </td>
              <td class="py-3 px-4">
                @if($rep->photo_identification)
                  <img src="{{ asset('storage/' . $rep->photo_identification) }}" class="w-16 h-16 rounded shadow object-cover" alt="Identificación">
                @else
                  -
                @endif
              </td>
              <td class="py-3 px-4">
                @if($rep->letter_of_no_criminal_record)
                  <img src="{{ asset('storage/' . $rep->letter_of_no_criminal_record) }}" class="w-16 h-16 rounded shadow object-cover" alt="Antecedentes">
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
