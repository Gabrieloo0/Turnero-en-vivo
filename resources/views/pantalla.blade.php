<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pantalla de Turnos</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="max-w-3xl mx-auto mt-12">
        <h1 class="text-3xl font-bold text-center text-yellow-400 mb-8">
            📢 Turnos en tiempo real
        </h1>

        <div id="lista-solicitudes" class="space-y-4">
            @foreach($solicitudes as $s)
                <div class="bg-gray-800 p-6 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <p class="text-4xl font-extrabold text-yellow-400">{{ $s->numero }}</p>
                        <p class="text-lg">{{ $s->user }} ({{ $s->dni }})</p>
                        <p class="text-md text-blue-300 font-semibold">{{ $s->tipo }}</p>
                        @if($s->puesto)
                            <p class="text-md text-green-400 font-bold">➡️ {{ $s->puesto }}</p>
                        @endif
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full text-sm 
                            @if($s->estado === 'pendiente') bg-yellow-600 text-white 
                            @elseif($s->estado === 'en_atencion') bg-blue-600 text-white 
                            @else bg-green-600 text-white @endif">
                            {{ ucfirst($s->estado) }}
                        </span>
                        <p class="text-xs text-gray-400 mt-2">{{ $s->created_at }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        window.Echo.channel('turnos') // ⚠️ debe coincidir con tu evento
            .listen('.SolicitudPosted', (e) => { // ⚠️ con punto
                const div = document.getElementById('lista-solicitudes');
                const item = document.createElement('div');
                item.className = "bg-blue-800 p-6 rounded-lg shadow flex items-center justify-between animate-pulse";
                item.innerHTML = `
                    <div>
                        <p class="text-4xl font-extrabold text-yellow-400">${e.numero}</p>
                        <p class="text-lg">${e.user} (${e.dni ?? ''})</p>
                        <p class="text-md text-blue-300 font-semibold">${e.tipo}</p>
                        ${e.puesto ? `<p class="text-md text-green-400 font-bold">➡️ ${e.puesto}</p>` : ''}
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full text-sm 
                            ${e.estado === 'pendiente' ? 'bg-yellow-600' : e.estado === 'en_atencion' ? 'bg-blue-600' : 'bg-green-600'} text-white">
                            ${e.estado}
                        </span>
                        <p class="text-xs text-gray-300 mt-2">${e.created_at}</p>
                    </div>
                `;
                div.prepend(item); // aparece arriba en la lista
            });
    </script>
</body>
</html>