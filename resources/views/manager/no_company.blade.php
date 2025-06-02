@extends('layouts.app')

@section('content')
<div class="p-8 min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">¡Aún no tienes una empresa registrada!</h1>
    <a href="{{ route('invite') }}" class="bg-blue-800 text-white px-4 py-2 rounded">Invitar a transportista</a>
</div>
@endsection
