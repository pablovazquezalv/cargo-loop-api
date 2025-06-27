<nav class="flex items-center justify-between px-6 py-4 shadow-sm">
    <div class="text-2xl font-bold">
      <a href="{{ url('/') }}">
        cargo loop
        <img src="/Carga-loop-icon.png" alt="Logo" class="h-8 inline-block" />
      </a>
    </div>
    <ul class="flex space-x-6">
      <li><a href="{{ url('/') }}">Generador de carga</a></li>
      <li><a href="#">Transportista</a></li>
      <li><a href="{{ url('/') }}">¿Quiénes somos?</a></li>
    </ul>
  <div class="flex space-x-3">
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

  </nav>
  