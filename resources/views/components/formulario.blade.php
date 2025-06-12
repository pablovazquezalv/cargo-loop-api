<section class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-2">Planea tu siguiente envío!</h2>
        <p class="text-center text-xl font-semibold text-blue-700 mb-6">Formulario</p>

        <form method="POST" action="{{ route('contacto.enviar') }}" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf

            <input
                type="email"
                name="email"
                placeholder="Tu correo electrónico"
                required
                class="flex-1 p-3 border-2 border-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            />

            <textarea
                name="mensaje"
                placeholder="Tu mensaje"
                required
                class="flex-1 p-3 border-2 border-blue-500 rounded-md h-24 resize-none focus:outline-none focus:ring-2 focus:ring-blue-400"
            ></textarea>

            <button
                type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all"
            >
                Enviar
            </button>
        </form>

        @if(session('success'))
            <p class="text-green-600 text-center mt-4">{{ session('success') }}</p>
        @endif

        @if($errors->any())
            <ul class="text-red-600 text-center mt-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
