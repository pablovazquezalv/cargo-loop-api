
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
    <img src="{{ asset('Carga-loop-icon.png') }}" alt="Logo" class="h-24 mb-6">
    <h1 class="text-3xl font-bold text-blue-800 mb-10">Carga loop</h1>

    @if(session('error'))
        <p class="text-red-600 mb-4 text-center">{{ session('error') }}</p>
    @endif

    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-10 text-center">Iniciar sesión</h1>

        <form action="{{ route('login.attempt') }}" method="POST">
            @csrf
            <label class="block mb-4">
                <span class="text-gray-700">Correo electrónico</span>
                <input
                    type="email"
                    name="email"
                    placeholder="Proporciona tu correo"
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                    required
                />
            </label>

            <label class="block mb-6">
                <span class="text-gray-700">Contraseña</span>
                <input
                    type="password"
                    name="password"
                    placeholder="Proporciona tu contraseña"
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                    required
                />
            </label>

            <button
                type="submit"
                class="w-full py-3 bg-blue-800 text-white rounded hover:bg-blue-900 transition-all"
            >
                Iniciar sesión
            </button>
        </form>

        <button
            onclick="document.getElementById('modal').classList.remove('hidden')"
            class="block w-full text-center text-blue-700 mt-4 hover:underline"
        >
            ¿Olvidaste tu contraseña?
        </button>
        <p class="text-center text-gray-600 mt-4">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-800 hover:underline">Crear cuenta</a>
        </p>
    </div>

    {{-- Modal de recuperación --}}
    {{-- <div id="modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-sm">
            <h2 class="text-lg font-semibold mb-4">Recuperar contraseña</h2>
            <p class="mb-4 text-sm text-gray-700">
                Ingresa tu correo y te enviaremos instrucciones para recuperar tu contraseña.
            </p>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <input
                    type="email"
                    name="email"
                    placeholder="Tu correo"
                    class="w-full mb-4 p-2 border rounded"
                    required
                />
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        onclick="document.getElementById('modal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-900"
                    >
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div> --}}
</div>
