<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../includes/php/header.php'; ?>

    <div class="container">
        <div class="kanban-board">
            <!-- Columna 1 -->
            <div class="kanban-column">
                <div class="kanban-header">Tareas pendientes</div>
            </div>

            <!-- Columna 2 -->
            <div class="kanban-column">
                <div class="kanban-header">Tareas en proceso</div>
            </div>

            <!-- Columna 3 -->
            <div class="kanban-column">
                <div class="kanban-header">Tareas pospuestas</div>
            </div>

            <!-- Columna 4 -->
            <div class="kanban-column">
                <div class="kanban-header">Tareas finalizadas</div>
            </div>

            <!-- Columna 5 -->
            <div class="kanban-column">
                <div class="kanban-header">Tareas extras</div>
            </div>
        </div>
    </div>

    <!--footer-->
    <?php include '../includes/php/footer.php'; ?>

    <script>
        // Obtener el ID de la nota desde la URL
        const urlParams = new URLSearchParams(window.location.search);
        const boardId = urlParams.get('boardId');

        // Verificar si el ID de la nota existe
        if (boardId) {
            // Cargar el contenido específico de la nota desde localStorage
            const boardData = JSON.parse(localStorage.getItem("boards")).find(board => board.id == boardId);
            if (boardData) {
                document.getElementById("kanbanContent1").innerText = boardData.description || "Sin contenido";
            } else {
                document.getElementById("kanbanContent1").innerText = "Nota no encontrada.";
            }
        } else {
            document.getElementById("kanbanContent1").innerText = "No se especificó una nota.";
        }
    </script>
</body>

</html>
