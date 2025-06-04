

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
<div id="invitationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Invitar a transportista</h2>
        <form method="POST" action="{{ route('manager.invite') }}">
            @csrf
            <input type="email" name="email" required class="w-full border rounded p-2 mb-4" placeholder="Correo electrónico">
            <button type="submit" class="bg-blue-800 text-white px-4 py-2 rounded">Enviar invitación</button>
        </form>
        <button class="mt-4 text-sm text-gray-500" onclick="document.getElementById('invitationModal').classList.add('hidden')">Cancelar</button>
    </div>
</div>
