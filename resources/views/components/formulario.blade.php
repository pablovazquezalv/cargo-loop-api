<section class="min-h-screen px-6 py-6 md:px-24 md:py-6 bg-white">
    <h3 class="text-2xl md:text-4xl font-bold text-blue-800 mb-6">Planea tu siguiente envío!</h3>
    <h2 class="text-3xl font-bold text-blue-800 mb-4">Formulario</h2>

    <form class="space-y-6">
        <div class="grid md:grid-cols-2 gap-6">
            <input type="text" placeholder="Nombre" class="p-4 border rounded w-full" />
            <input type="email" placeholder="Email" class="p-4 border rounded w-full" />
        </div>

        <div class="flex flex-col md:flex-row items-center gap-4">
            <label class="flex items-center gap-2">
                <input type="radio" name="tipoUsuario" value="cliente" class="cursor-pointer" />
                Cliente
            </label>
            <label class="flex items-center gap-2">
                <input type="radio" name="tipoUsuario" value="transportista" class="cursor-pointer" />
                Transportista
            </label>
        </div>

        <textarea placeholder="Mensaje" class="p-4 border rounded w-full"></textarea>

        <button type="submit" class="px-6 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 transition-all">
            Enviar
        </button>
    </form>
</section>
