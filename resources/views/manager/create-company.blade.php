<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
   <meta property="og:title" content="Carga Loop - Plataforma de Traslado de Carga" />
  <meta property="og:description" content="Conecta con generadores de carga y optimiza tus envíos con Carga Loop. Somos un grupo de profesionales expertos en logística con más de 20 años de experiencia." />
  <meta property="og:image" content="https://www.mx.cargo-loop.com/Carga-loop-og.png" />
  <meta property="og:url" content="https://www.mx.cargo-loop.com" />
  <meta property="og:type" content="website" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>cargo Loop</title>
  {{-- ✅ Tailwind CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
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
<body>
<x-navbar />

<div class="flex flex-col items-center justify-center min-h-screen bg-white px-4">
    <img src="{{ asset('cargo-loop-icon.png') }}" alt="Logo" class="h-24 mb-6" />
    <h1 class="text-3xl font-bold text-blue-800 mb-10">Crear Empresa</h1>

    @if(session('error'))
        <div class="mb-4 text-red-600">{{ session('error') }}</div>
    @endif

    <form action="{{ route('manager.createCompany') }}" method="POST" enctype="multipart/form-data"
          class="w-full max-w-lg p-8 bg-white rounded-lg shadow-md">
        @csrf

        @foreach ([
            ['id' => 'name', 'label' => 'Nombre de la Empresa', 'type' => 'text', 'required' => true],
            ['id' => 'business_name', 'label' => 'Razón Social', 'type' => 'text'],
            ['id' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
            ['id' => 'phone', 'label' => 'Teléfono', 'type' => 'text'],
                        ['id' => 'website', 'label' => 'Sitio Web', 'type' => 'url'],

            ['id' => 'address', 'label' => 'Dirección', 'type' => 'text'],
            ['id' => 'city', 'label' => 'Ciudad', 'type' => 'text'],
            // OMITIMOS 'state' AQUÍ
            ['id' => 'postal_code', 'label' => 'Código Postal', 'type' => 'text'],
        ] as $field)
            <label for="{{ $field['id'] }}" class="block mb-4">
                <span class="text-gray-700">{{ $field['label'] }}</span>
                <input
                    type="{{ $field['type'] }}"
                    id="{{ $field['id'] }}"
                    name="{{ $field['id'] }}"
                    value="{{ old($field['id']) }}"
                    @if (!empty($field['required'])) required @endif
                    class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                />
                @error($field['id'])
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </label>
        @endforeach

        {{-- Select de estados de México --}}
        <label for="state" class="block mb-4">
            <span class="text-gray-700">Estado</span>
            <select
                id="state"
                name="state"
                class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
                required
            >
                <option value="">Selecciona un estado</option>
                @foreach([
                    'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 'Chiapas',
                    'Chihuahua', 'Ciudad de México', 'Coahuila', 'Colima', 'Durango',
                    'Estado de México', 'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco',
                    'Michoacán', 'Morelos', 'Nayarit', 'Nuevo León', 'Oaxaca',
                    'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa',
                    'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz',
                    'Yucatán', 'Zacatecas'
                ] as $estado)
                    <option value="{{ $estado }}" @if(old('state') == $estado) selected @endif>{{ $estado }}</option>
                @endforeach
            </select>
            @error('state')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </label>

        <label class="block mb-4">
            <span class="text-gray-700">Imagen de Perfil</span>
            <input
                type="file"
                id="profile_picture"
                name="profile_picture"
                accept="image/*"
                class="w-full mt-2 p-2 border rounded text-sm text-gray-700"
            />
            @error('profile_picture')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </label>

        <label class="block mb-6">
            <span class="text-gray-700">Descripción</span>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="w-full mt-2 p-3 border rounded focus:outline-none focus:ring focus:ring-blue-200"
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </label>

        <button
            type="submit"
            class="w-full py-3 bg-blue-800 text-white rounded hover:bg-blue-900 transition-all"
        >
            Crear Empresa
        </button>
    </form>
</div>
</body>
</html>
