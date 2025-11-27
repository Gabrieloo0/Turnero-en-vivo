# Proyecto Turnero en Vivo

Sistema de turnos desarrollado con Laravel, Broadcasting, Laravel Reverb, Echo y Queues, que permite visualizar en tiempo real el avance de solicitudes de turnos sin necesidad de recargar la página.

## Integrantes del Grupo
- Coronel, Gabriel
- Gavilan, Agostina
- Medina, Maira
- Otazo, Julián
- Rodas, Lourdes
- Viera, Patricia

## Funcionalidades Principales

- Registro de turnos mediante formulario.
- Visualización en tiempo real de turnos (pendiente → en_atencion → finalizado).
- Comunicación instantánea mediante Laravel Reverb + Echo.
- Procesamiento automático de cambios con Laravel Queues (database driver).
- Actualización dinámica de la interfaz usando WebSockets.

## Instalación y Puesta en Marcha del Proyecto

### 1. Clonar el repositorio
```bash
git clone https://github.com/Gabrieloo0/Turnero-en-vivo.git
```

### 2. Configurar variables de entorno
Crear el archivo .env:
```bash
cp .env.example .env
```

### 3. Instalar dependencias
- Dependencias PHP (Composer):
```bash
composer install
```
- Generar APP_KEY:

```bash
php artisan key:generate
```
- Dependencias Node:
```bash
npm install
```

### 4. Migrar base de datos
```bash
php artisan migrate
```

### 5. Puesta en Marcha del proyecto
Para que el sistema funcione en tiempo real se neesita correr el siguiente comando:
- Unica terminal para levantar todo el proyecto
```bash
composer run dev
```

En caso de que lo anterior no funcione, es necesario iniciar estos cuatro procesos simultáneamente, en terminales diferentes:

- Terminal 1 — Servidor Web de Laravel
```bash
php artisan serve
```
- Terminal 2 — Vite (Frontend)
```bash
npm run dev
```
- Terminal 3 — WebSockets (Laravel Reverb)
```bash
php artisan reverb:start
```
- Terminal 4 — Cola de Trabajos (Jobs)
```bash
php artisan queue:work
```
### 6. Cómo probar el Turnero en Vivo

Para ver el sistema funcionando en tiempo real, es necesario abrir dos pestañas de navegador simultáneamente, como se indica a continuación:

1) En la primera pestaña abrir: http://127.0.0.1:8000/solicitud

   → Completar el formulario para registrar un nuevo turno

2) En la segunda pestaña abrir: http://127.0.0.1:8000/pantalla

    → Ver el turno aparecer automáticamente

3) Observar cómo el turno progresa:

     - pendiente → en_atencion (10s)

    - en_atencion → finalizado (30s)
