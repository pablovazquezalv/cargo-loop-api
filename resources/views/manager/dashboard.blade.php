<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carga Loop</title>
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
<body>
  <x-navbar />

  <div class="p-8 bg-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-8">

      <h1 class="text-4xl font-bold text-gray-900">Hola Manager</h1>
      <button class="bg-blue-800 text-white px-4 py-2 rounded" onclick="openModal()">Invitar a transportista</button>
    </div>

    <div class="grid grid-cols-4 gap-6 mb-8">
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
        <div class="col-span-4 bg-white shadow-md rounded-lg p-6 flex items-center space-x-6 mt-4">
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

  {{-- Modal --}}
  <div id="invitationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Invitar a transportista</h2>
      <form method="POST" action="{{ route('invite') }}">
        @csrf
        <input type="email" name="email" required class="w-full border rounded p-2 mb-4" placeholder="Correo electrónico" />
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
