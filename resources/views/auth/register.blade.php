
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
<div class="flex flex-col items-center justify-center min-h-screen bg-white">
    <h1 class="text-3xl font-bold text-blue-800 mb-10">Crear cuenta</h1>
    <img src="{{ asset('Carga-loop-icon.png') }}" alt="Logo" class="h-24 mb-6" />

    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-10 text-center">Carga loop</h1>

        @if (session('success'))
            <p class="text-green-600 mb-4 text-center">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <div class="text-red-600 mb-4 text-center">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.manager') }}">
            @csrf

            <label class="block mb-4">
                <span class="text-gray-700 font-semibold">Nombre</span>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Proporciona tu nombre" />
            </label>

            <label class="block mb-4">
                <span class="text-gray-700 font-semibold">Apellido</span>
                <input type="text" name="apellido" value="{{ old('apellido') }}" required
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Proporciona tu apellido" />
            </label>

            <label class="block mb-4">
                <span class="text-gray-700 font-semibold">Correo electrónico</span>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Proporciona tu correo" />
            </label>

            <label class="block mb-4">
                <span class="text-gray-700 font-semibold">Teléfono</span>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Proporciona tu teléfono" />
            </label>

            <label class="block mb-4">
                <span class="text-gray-700 font-semibold">Contraseña</span>
                <input type="password" name="password" required
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Proporciona tu contraseña" />
            </label>

            <label class="block mb-6">
                <span class="text-gray-700 font-semibold">Confirmar Contraseña</span>
                <input type="password" name="password_confirmation" required
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Confirma tu contraseña" />
            </label>

            <button type="submit"
                class="w-full py-3 bg-blue-800 text-white rounded hover:bg-blue-900 transition-all">
                Crear cuenta
            </button>
            <p class="text-center text-gray-600 mt-4">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-800 hover:underline">Iniciar sesión</a>
            </p>
        </form>
    </div>
</div>
<script>
    // Animaciones al cargar
    document.addEventListener('DOMContentLoaded', () => {
        const elements = document.querySelectorAll('.fade-in, .zoom-in');
        elements.forEach((el, index) => {
            el.classList.add(`fade-delay-${index + 1}`);
            el.classList.remove('hidden');
        });
    });
