<nav class="bg-white shadow-sm px-4 sm:px-6 py-4">
  <div class="flex items-center justify-between">
    <!-- Logo -->
    <div class="text-2xl font-bold flex items-center space-x-2">
      <a href="{{ url('/') }}" class="flex items-center space-x-2">
        <img src="/Carga-loop-icon.png" alt="Logo" class="h-8" />
        <span class="hidden sm:inline">Carga Loop</span>
      </a>
    </div>

    <!-- Botón menú móvil -->
    <button class="sm:hidden text-gray-700 focus:outline-none" onclick="toggleMobileMenu()">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Menú en pantallas grandes -->
    <ul class="hidden sm:flex space-x-6 items-center text-gray-800 font-medium">
      @auth
        <li><a href="{{ url('/dashboard') }}" class="hover:text-blue-600">Inicio</a></li>
      @endauth
      <li><a href="{{ url('/') }}" class="hover:text-blue-600">Generador de carga</a></li>
      <li><a href="#" class="hover:text-blue-600">Transportista</a></li>
      <li><a href="{{ url('/') }}" class="hover:text-blue-600">¿Quiénes somos?</a></li>
    </ul>

    <!-- Botones de autenticación -->
    <div class="hidden sm:flex space-x-3">
      @auth
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="px-4 py-1 text-white bg-red-600 rounded">Cerrar sesión</button>
        </form>
      @else
        <a href="{{ url('/login') }}" class="px-4 py-1 text-white bg-blue-800 rounded">Iniciar sesión</a>
        <a href="{{ url('/register') }}" class="px-4 py-1 text-white bg-blue-800 rounded">Crear cuenta</a>
      @endauth
    </div>
  </div>

  <!-- Menú móvil desplegable -->
  <div id="mobileMenu" class="sm:hidden mt-4 hidden flex-col space-y-3 text-gray-800 font-medium">
    <ul class="space-y-2">
      @auth
        <li><a href="{{ url('/dashboard') }}" class="block hover:text-blue-600">Inicio</a></li>
      @endauth
      <li><a href="{{ url('/') }}" class="block hover:text-blue-600">Generador de carga</a></li>
      <li><a href="#" class="block hover:text-blue-600">Transportista</a></li>
      <li><a href="{{ url('/') }}" class="block hover:text-blue-600">¿Quiénes somos?</a></li>
    </ul>

    <div class="pt-2 border-t border-gray-200">
      @auth
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="block w-full text-left px-4 py-2 bg-red-600 text-white rounded">Cerrar sesión</button>
        </form>
      @else
        <a href="{{ url('/login') }}" class="block w-full px-4 py-2 bg-blue-800 text-white rounded mb-2">Iniciar sesión</a>
        <a href="{{ url('/register') }}" class="block w-full px-4 py-2 bg-blue-800 text-white rounded">Crear cuenta</a>
      @endauth
    </div>
  </div>
</nav>

<script>
  function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
  }
</script>
