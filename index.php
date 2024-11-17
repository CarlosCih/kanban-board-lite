<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <?php include 'includes/php/head.php'; ?>

</head>

<body>
    <!--navbar-->
    <?php include 'includes/php/header.php'; ?>
    <!-- Encabezado de la Página -->
    <header class="container my-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-primary">Mis Tableros</h1>
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
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newBoardModal">Crear tu primer tablero</button>
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
                            <input type="text" class="form-control" id="boardName" placeholder="Ingresa el nombre del tablero" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="boardDescription">Descripción del Tablero</label>
                            <textarea class="form-control" id="boardDescription" placeholder="Agrega una breve descripción" rows="2"></textarea>
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