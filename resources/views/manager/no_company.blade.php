
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta property="og:title" content="Carga Loop - Plataforma de Traslado de Carga" />
  <meta property="og:description" content="Conecta con generadores de carga y optimiza tus envíos con Carga Loop. Somos un grupo de profesionales expertos en logística con más de 20 años de experiencia." />
  <meta property="og:image" content="https://www.mx.cargo-loop.com/Carga-loop-og.png" />
  <meta property="og:url" content="https://www.mx.cargo-loop.com" />
  <meta property="og:type" content="website" />
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

<div class="p-8 min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">¡Aún no tienes una empresa registrada!</h1>
    <a href="{{ route('manager.createForm') }}" class="bg-blue-800 text-white px-4 py-2 rounded">Dar de alta empresa</a>
</div>

</html>