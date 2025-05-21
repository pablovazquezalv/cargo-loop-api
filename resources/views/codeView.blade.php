<!-- resources/views/codigo-autenticacion.blade.php -->
@extends('layouts.app') {{-- o el layout que estés usando --}}

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center bg-white px-4">
    <h1 class="text-4xl font-bold text-blue-800 mb-10">Código de Autenticación</h1>
    <p class="text-lg text-gray-700 mb-6">Ingresa el código que se te mandó al teléfono.</p>
    <form id="authForm" action="{{ route('verificar.codigo') }}" method="POST">
        @csrf
        <div class="flex gap-4 mb-6">
            @for ($i = 0; $i < 4; $i++)
                <input
                    id="code-{{ $i }}"
                    name="code[]"
                    type="text"
                    maxlength="1"
                    class="w-12 h-12 text-center border rounded-md text-2xl"
                    oninput="handleInput(event, {{ $i }})"
                />
            @endfor
        </div>
        <p class="text-gray-700 mb-6">¿No te llegó ningún correo? <span class="text-blue-800 cursor-pointer" onclick="reenviarCodigo()">Reenviar</span></p>
        <button 
            type="submit"
            class="w-full max-w-xs py-3 bg-blue-800 text-white text-lg"
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
            e.target.value = ''; // limpiar si no es un número
        }
    }

    function reenviarCodigo() {
        alert('Código reenviado (simulado)');
        // aquí puedes hacer una llamada fetch o redirigir a una ruta para reenviar
    }
</script>
@endsection
