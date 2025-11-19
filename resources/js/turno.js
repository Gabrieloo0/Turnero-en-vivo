if (window.Echo) {
    console.log("Echo conectado, escuchando canal 'turno'...");
    window.Echo.channel("turno")
    .listen("turno.posted", (e) => {
    const box = document.getElementById("solicitud");
    if (!box) return;
    const div = document.createElement("div");
    div.className = "msg";
    div.dataset.id = e.id;
    div.innerHTML = `
    <div><strong>${e.user ?? "Anon"}:</strong>
    ${e.content}</div>
    <div class="meta">${e.created_at}</div>
    `;
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
});
} else {
    console.warn("Echo no se inicializó todavía.");
}