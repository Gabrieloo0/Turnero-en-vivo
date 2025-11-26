<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Solicitud de Turnos</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="max-w-lg mx-auto mt-12 bg-gray-800 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold text-yellow-400 mb-6 text-center">
            🏦 Solicitud de Turnos (Laravel + Reverb)
        </h1>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="bg-green-700 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="bg-red-700 text-white p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('solicitud.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="user" class="block text-gray-300 font-semibold">Tu nombre</label>
                <input id="user" type="text" name="user" value="{{ old('user') }}"
                       class="w-full border border-gray-600 bg-gray-700 text-white rounded-lg p-2 focus:ring focus:ring-yellow-400">
                @error('user')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="dni" class="block text-gray-300 font-semibold">DNI</label>
                <input id="dni" type="text" name="dni" value="{{ old('dni') }}"
                       class="w-full border border-gray-600 bg-gray-700 text-white rounded-lg p-2 focus:ring focus:ring-yellow-400">
                @error('dni')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-gray-300 font-semibold">Motivo de turno</label>
                <input id="content" type="text" name="content" value="{{ old('content') }}" required
                       class="w-full border border-gray-600 bg-gray-700 text-white rounded-lg p-2 focus:ring focus:ring-yellow-400">
                @error('content')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tipo" class="block text-gray-300 font-semibold">Tipo de atención</label>
                <select id="tipo" name="tipo"
                        class="w-full border border-gray-600 bg-gray-700 text-white rounded-lg p-2 focus:ring focus:ring-yellow-400">
                    <option value="CAJA" {{ old('tipo') === 'CAJA' ? 'selected' : '' }}>Caja</option>
                    <option value="AT" {{ old('tipo') === 'AT' ? 'selected' : '' }}>Atención al Cliente</option>
                </select>
                @error('tipo')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-yellow-400 text-gray-900 font-bold py-2 rounded-lg hover:bg-yellow-500 transition">
                Generar Turno
            </button>
        </form>
    </div>
</body>
</html>