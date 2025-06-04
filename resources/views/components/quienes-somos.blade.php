<section class="min-h-screen px-6 py-12 md:px-24 md:py-20 bg-white">
    <div class="grid md:grid-cols-2 gap-12 items-start">
        {{-- Texto --}}
        <div class="space-y-10">
            <div class="p-6">
                <h2 class="text-3xl font-bold text-blue-800 mb-4">Visión</h2>
                <p class="text-gray-800 mb-4">
                    Impulsar una red justa y eficiente que profesionalice a los transportistas y facilite a las empresas mover su carga con seguridad, puntualidad y transparencia
                </p>
            </div>

            <div class="p-6">
                <h2 class="text-3xl font-bold text-blue-800 mb-4">Misión</h2>
                <p class="text-gray-800">
                    Transformar la logística de carga en México, impulsando la eficiencia, la transparencia y la confianza entre quienes necesitan mover mercancías y quienes pueden hacerlo.
                </p>
            </div>
        </div>

        {{-- Imagen --}}
        <div class="flex justify-center">
            <img 
                src="{{ asset('logistics-person.jpg') }}" 
                alt="Trabajador logístico" 
                class="rounded shadow-md w-[500px] h-[350px] object-cover"
            />
        </div>
    </div>
</section>
