
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carga Loop</title>
  {{-- ✅ Tailwind CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* ✅ Animaciones básicas */
    .fade-in {
      opacity: 0;
      transform: translateY(-30px);
      animation: fadeIn 0.8s ease-out forwards;
    }
    .fade-delay-1 { animation-delay: 0.4s; }
    .fade-delay-2 { animation-delay: 0.6s; }
    .zoom-in { transform: scale(0.8); animation: zoomIn 0.8s ease-out forwards; animation-delay: 0.8s; }

    @keyframes fadeIn {
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes zoomIn {
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<x-navbar />


<div class="p-8 bg-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Hola Manager</h1>
        <a href="{{ route('invite') }}" class="bg-blue-800 text-white px-4 py-2 rounded">Invitar a transportista</a>
    </div>

    <div class="grid grid-cols-4 gap-6 mb-8">
        @foreach([
            ['value' => $dashboardData['unidades'], 'label' => 'Unidades', 'icon' => '🚛'],
            ['value' => $dashboardData['transportistas'], 'label' => 'Transportistas', 'icon' => '👤'],
            ['value' => $dashboardData['entregasEnProceso'], 'label' => 'Entregas en Proceso', 'icon' => '📦'],
            ['value' => $dashboardData['entregasCompletas'], 'label' => 'Entregas Completas', 'icon' => '✅'],
        ] as $item)
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <div class="text-4xl mb-2">{{ $item['value'] }}</div>
                <div class="text-5xl mb-2">{{ $item['icon'] }}</div>
                <div class="text-gray-500">{{ $item['label'] }}</div>
            </div>
        @endforeach
    </div>
</div>