
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cargo Loop</title>
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

<body class="bg-white text-center">

  <main class="min-h-screen px-4">
    <section class="flex flex-col items-center justify-center mt-24">
      <h1 class="text-4xl md:text-6xl font-bold text-blue-800 mb-6 fade-in">¡Haz tus envíos más seguros!</h1>

      <p class="text-lg text-gray-700 mb-2 fade-in fade-delay-1">
        Grupo de profesionales expertos en logística con más de 20 años de experiencia.
      </p>

      <p class="text-lg text-gray-700 fade-in fade-delay-2">
        Nuestra plataforma te conecta con los generadores de carga.
      </p>

      <div class="flex justify-center mt-8 zoom-in">
        <img
          src="/logistics-person.jpg"
          alt="Trabajador logístico"
          class="rounded shadow-md w-full max-w-lg"
        />
      </div>
    </section>

    @include('components.quienes-somos')
    @include('components.beneficios')
    @include('components.formulario')
    @include('components.footer')

  </main>

</body>
</html>
