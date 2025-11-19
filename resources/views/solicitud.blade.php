<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Turno en tiempo real (Laravel + Reverb)</title>
@vite(['resources/css/app.css','resources/js/app.js'])

<style>
    body { font-family: system-ui, sans-serif; margin: 20px; }
    .wrap { max-width: 720px; margin: 0 auto; }
    .box { border: 1px solid #ddd; border-radius: 12px; padding: 16px; }
    .msg { padding: 8px 0; border-bottom: 1px solid #eee; }
    .msg:last-child { border-bottom: none; }
    .meta { font-size: 12px; opacity: 0.7; }
    .row { display: flex; gap: 8px; margin-top: 12px; }
    input, button { padding: 10px 12px; border-radius: 8px; border: 1px
    solid #ccc; }
    button { cursor: pointer; }
</style>
</head>

<body>
    <div class="wrap">
        <h1>Solicitud de turnos(Laravel + Reverb)</h1>
        
        <div class="box" id="messages">
        @foreach($solicitud as $sol)
            <div class="msg" data-id="{{ $sol->id }}">
                <div><strong>{{ $sol->user ?? 'Anon' }}:</strong> {{ $sol->content}}
            </div>
            <div class="meta">{{ $sol->created_at }}
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="row">
        <input id="user" type="text" placeholder="Tu nombre" />
        <input id="content" type="text" placeholder="Motivo de turno"style="flex:1" />
        <button id="send">Enviar</button>
    </div>
    
    <script>
    document.getElementById('send').addEventListener('click', async () => {
        const user = document.getElementById('user').value;
        const content = document.getElementById('content').value.trim();
        if (!content) return;
        const res = await fetch('{{ route('turno.store') }}', {
            method: 'POST',headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{
            csrf_token() }}' },
            body: JSON.stringify({ user, content })
        });
        if (res.ok) document.getElementById('content').value = '';
    });
    </script>
</body>
</html