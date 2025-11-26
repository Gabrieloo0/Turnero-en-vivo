if (window.Echo) {
    console.log("Echo conectado, escuchando canal 'turnos'...");

    window.Echo.channel("turnos")
        .listen(".SolicitudPosted", (e) => {
            console.log("Evento recibido:", e);

            const box = document.getElementById("lista-solicitudes");
            if (!box) return;

            // Buscar si ya existe un elemento con ese turno
            let div = document.querySelector(`[data-numero="${e.numero}"]`);

            if (!div) {
                // Si no existe, lo creamos
                div = document.createElement("div");
                div.className = "bg-gray-800 p-6 rounded-lg shadow flex items-center justify-between";
                div.dataset.numero = e.numero;
                box.prepend(div);
            }

            // Actualizar contenido del turno existente
            div.innerHTML = `
                <div>
                    <p class="text-4xl font-extrabold text-yellow-400">${e.numero}</p>
                    <p class="text-lg">${e.user ?? "Anon"} (${e.dni ?? ""})</p>
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
        });
} else {
    console.warn("Echo no se inicializó todavía.");
}