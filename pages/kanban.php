<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban</title>
    <?php include '../includes/php/head.php'; ?>
    <style>
        .kanban-item {
            cursor: grab;
        }

        .kanban-column {
            border: 1px solid #ddd;
            padding: 10px;
            min-height: 200px;
        }

        .kanban-column.over {
            background-color: #f0f8ff;
        }
    </style>
</head>

<body>
    <?php include '../includes/php/header.php'; ?>

    <div class="aggTarea">
        <button id="btnAgregarTarea" style="width: 250px;" class="btn btn-secondary mt-2">Agregar Tarea</button>
    </div>

    <div class="container">
        <div class="kanban-board d-flex justify-content-between">
            <!-- Columna 1 -->
            <div class="kanban-column" id="tareasPendientes" ondragover="permitirDrop(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas pendientes</div>
            </div>

            <!-- Columna 2 -->
            <div class="kanban-column" id="tareasEnProceso" ondragover="permitirDrop(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas en proceso</div>
            </div>

            <!-- Columna 3 -->
            <div class="kanban-column" id="tareasPospuestas" ondragover="permitirDrop(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas pospuestas</div>
            </div>

            <!-- Columna 4 -->
            <div class="kanban-column" id="tareasFinalizadas" ondragover="permitirDrop(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas finalizadas</div>
            </div>

            <!-- Columna 5 -->
            <div class="kanban-column" id="tareasExtras" ondragover="permitirDrop(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas extras</div>
            </div>
        </div>
    </div>

    <?php include '../includes/php/footer.php'; ?>

    <script>
        const obtenerBoardId = () => {
            const params = new URLSearchParams(window.location.search);
            return params.get("boardId") || "defaultBoardId";
        };
        // Cargar tareas existentes desde localStorage
        const cargarTareas = () => {
            const boardId = obtenerBoardId();
            if (!boardId) {
                alert("No se encontró el ID del tablero.");
                return;
            }

            const columnas = ["tareasPendientes", "tareasEnProceso", "tareasPospuestas", "tareasFinalizadas", "tareasExtras"];
            columnas.forEach((columnaId) => {
                const contenedor = document.getElementById(columnaId);
                const encabezado = contenedor.querySelector(".kanban-header");

                // Las tareas ahora están vinculadas al boardId
                const tareas = JSON.parse(localStorage.getItem(`${boardId}-${columnaId}`)) || [];

                contenedor.innerHTML = "";
                contenedor.appendChild(encabezado);

                tareas.forEach((tarea) => {
                    const tareaElemento = document.createElement("div");
                    tareaElemento.classList.add("kanban-item", "p-2", "mb-2", "bg-light", "border");
                    tareaElemento.textContent = tarea;
                    tareaElemento.draggable = true;

                    tareaElemento.ondragstart = (event) => {
                        event.dataTransfer.setData("text", JSON.stringify({
                            tarea,
                            origen: `${boardId}-${columnaId}`
                        }));
                    };

                    contenedor.appendChild(tareaElemento);
                });
            });
        };


        const agregarTarea = () => {
            const nuevaTarea = prompt("Ingresa la descripción de la nueva tarea:");
            if (nuevaTarea) {
                const boardId = obtenerBoardId();
                if (!boardId) return;

                const tareasPendientes = JSON.parse(localStorage.getItem(`${boardId}-tareasPendientes`)) || [];
                tareasPendientes.push(nuevaTarea);
                localStorage.setItem(`${boardId}-tareasPendientes`, JSON.stringify(tareasPendientes));
                cargarTareas(); // Actualizar vista
            }
        };

        // Permitir arrastrar sobre una columna
        const permitirDrop = (event) => {
            event.preventDefault();
            event.currentTarget.classList.add("over");
        };

        // Eliminar estado "over" al salir
        const quitarOver = (event) => {
            event.currentTarget.classList.remove("over");
        };

        // Soltar 
        const soltarTarea = (event) => {
            event.preventDefault();
            event.currentTarget.classList.remove("over");

            const boardId = obtenerBoardId();
            if (!boardId) return;

            const {
                tarea,
                origen
            } = JSON.parse(event.dataTransfer.getData("text"));
            const destinoId = event.currentTarget.id;

            // Remover tarea del origen
            const tareasOrigen = JSON.parse(localStorage.getItem(origen)) || [];
            const index = tareasOrigen.indexOf(tarea);
            if (index > -1) tareasOrigen.splice(index, 1);
            localStorage.setItem(origen, JSON.stringify(tareasOrigen));

            // Agregar tarea al destino
            const tareasDestino = JSON.parse(localStorage.getItem(`${boardId}-${destinoId}`)) || [];
            tareasDestino.push(tarea);
            localStorage.setItem(`${boardId}-${destinoId}`, JSON.stringify(tareasDestino));

            cargarTareas(); // Actualizar vista
        };


        document.getElementById("btnAgregarTarea").addEventListener("click", agregarTarea);

        // Cargar tareas al inicio
        cargarTareas();
    </script>
</body>

</html>