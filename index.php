<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Manifest -->
    <link rel="manifest" href="manifest.json">

    <!-- Meta para dispositivos móviles -->
    <meta name="theme-color" content="#007bff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Tableros PWA">

    <!-- Íconos para iOS -->
    <link rel="apple-touch-icon" href="assets/icons/icon-192x192.png">

    <!-- Registrar el Service Worker -->
    <script>
    if ("serviceWorker" in navigator) {
        window.addEventListener("load", () => {
            navigator.serviceWorker
                .register("serviceworker.js")
                .then((registration) => {
                    console.log("Service Worker registrado con éxito:", registration);
                })
                .catch((error) => {
                    console.error("Error al registrar el Service Worker:", error);
                });
        });
    }
    </script>
    
</head>

<body>
    <!--navbar-->
    <?php include 'includes/php/header.php'; ?>
    <!-- Encabezado de la Página -->
    <header class="container my-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="">Mis Tableros</h1>
        </div>
    </header>

    <!-- Sección de Lista de Tableros -->
    <main class="container">
        <div id="boardList" class="row">
            <!-- Aquí se cargarán los tableros existentes -->
            <!-- Vista Vacía para Nuevos Usuarios -->
            <div id="emptyState" class="col-12 text-center my-5" style="display: none;">
                <h3>No tienes tableros aún</h3>
                <p class="text-muted">Crea tu primer tablero para empezar a organizar tus tareas</p>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newBoardModal">Crear tu primer
                    tablero</button>
            </div>
        </div>
    </main>

    <!-- Modal para crear o editar un tablero -->
    <div class="modal fade" id="newBoardModal" tabindex="-1" aria-labelledby="newBoardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newBoardModalLabel">Agregar Nuevo Tablero</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newBoardForm">
                        <div class="form-group">
                            <label for="boardName">Nombre del Tablero</label>
                            <input type="text" class="form-control" id="boardName"
                                placeholder="Ingresa el nombre del tablero" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="boardDescription">Descripción del Tablero</label>
                            <textarea class="form-control" id="boardDescription"
                                placeholder="Agrega una breve descripción" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--footer-->
    <?php include 'includes/php/footer.php'; ?>
</body>

</html>