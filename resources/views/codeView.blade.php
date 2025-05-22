<!-- resources/views/codigo-autenticacion.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Autenticación</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-white font-sans">

<main class="min-h-screen flex flex-col items-center justify-center px-4">
    <h1 class="text-4xl font-bold text-blue-800 mb-10">Código de Autenticación</h1>

    <p class="text-lg text-gray-700 mb-6">Hola, {{ $user->name }}</p>
    <p class="text-lg text-gray-700 mb-6">Ingresa el código que se te mandó al correo.</p>

    <form id="authForm" action="{{ route('reset.password', ['id' => $user->id]) }}" method="POST">
        @csrf
        <div class="flex gap-4 justify-center mb-6">
            @for ($i = 0; $i < 4; $i++)
                <input
                    id="code-{{ $i }}"
                    name="code[]"
                    type="text"
                    maxlength="1"
                    class="w-12 h-12 text-center border border-gray-300 rounded-md text-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                    oninput="handleInput(event, {{ $i }})"
                />
            @endfor
        </div>

        <p class="text-gray-700 mb-6">
            ¿No te llegó ningún correo? 
            <span class="text-blue-800 cursor-pointer hover:underline" onclick="reenviarCodigo()">Reenviar</span>
        </p>

        <button 
            type="submit"
            class="w-full max-w-xs py-3 bg-blue-800 text-white text-lg rounded-md hover:bg-blue-700 transition duration-200 ease-in-out"
        >
            Ingresar
        </button>
    </form>
</main>

<script>
    function handleInput(e, index) {
        const value = e.target.value;
        if (/^\d?$/.test(value)) {
            if (value && index < 3) {
                const nextInput = document.getElementById(`code-${index + 1}`);
                if (nextInput) nextInput.focus();
            }
        } else {
            e.target.value = '';
        }
    }

    function reenviarCodigo() {
        alert('Código reenviado (simulado)');
        // Aquí puedes usar fetch o redirigir a una ruta para reenviar el código real
    }
</script>

</body>
</html>
