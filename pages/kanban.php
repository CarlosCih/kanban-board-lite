<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban</title>
    <?php include '../includes/php/head.php'; ?>

    <style>
        .modal-content {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background-color: #6c757d;
            color: white;
        }

        .modal-footer .btn-primary {
            background-color: #198754;
        }

        .kanban-item {
            cursor: grab;
        }

        .kanban-column {
            border: 1px solid #ddd;
            padding: 10px;
            min-height: 200px;
        }

        .kanban-column.over {
            background-color: #e0ffe0;
            border: 2px dashed #198754;
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
            <!-- Columnas del Kanban -->
            <div class="kanban-column" id="tareasPendientes" ondragover="permitirDrop(event)" ondragleave="quitarOver(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas pendientes</div>
            </div>
            <div class="kanban-column" id="tareasEnProceso" ondragover="permitirDrop(event)" ondragleave="quitarOver(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas en proceso</div>
            </div>
            <div class="kanban-column" id="tareasPospuestas" ondragover="permitirDrop(event)" ondragleave="quitarOver(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas pospuestas</div>
            </div>
            <div class="kanban-column" id="tareasFinalizadas" ondragover="permitirDrop(event)" ondragleave="quitarOver(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas finalizadas</div>
            </div>
            <div class="kanban-column" id="tareasExtras" ondragover="permitirDrop(event)" ondragleave="quitarOver(event)" ondrop="soltarTarea(event)">
                <div class="kanban-header">Tareas extras</div>
            </div>
        </div>
    </div>

    <?php include '../includes/php/footer.php'; ?>

    <!-- Modal -->
    <div class="modal fade" id="modalAgregarTarea" tabindex="-1" aria-labelledby="modalAgregarTareaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarTareaLabel">TAREA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descripcionTarea" class="form-label">Nombre de tarea</label>
                        <input type="text" id="descripcionTarea" class="form-control" placeholder="Escribe la descripción...">
                    </div>
                    <div class="mb-3">
                        <label for="detallesTarea" class="form-label">Descripción de la tarea</label>
                        <textarea id="detallesTarea" class="form-control" rows="3" placeholder="Escribe los detalles..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarTarea">Guardar Tarea</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const obtenerBoardId = () => {
            const params = new URLSearchParams(window.location.search);
            return params.get("boardId") || "defaultBoardId";
        };

        const cargarTareas = () => {
            const boardId = obtenerBoardId();
            const columnas = ["tareasPendientes", "tareasEnProceso", "tareasPospuestas", "tareasFinalizadas", "tareasExtras"];
            columnas.forEach(columnaId => {
                const contenedor = document.getElementById(columnaId);
                const encabezado = contenedor.querySelector(".kanban-header");

                const tareas = JSON.parse(localStorage.getItem(`${boardId}-${columnaId}`)) || [];
                contenedor.innerHTML = "";
                contenedor.appendChild(encabezado);

                tareas.forEach(tarea => {
                    const tareaElemento = document.createElement("div");
                    tareaElemento.classList.add("kanban-item", "p-2", "mb-2", "bg-light", "border");
                    tareaElemento.textContent = tarea.descripcion;
                    tareaElemento.draggable = true;

                    // Mostrar modal en modo de solo lectura
                    tareaElemento.onclick = () => {
                        document.getElementById("descripcionTarea").value = tarea.descripcion;
                        document.getElementById("detallesTarea").value = tarea.detalles;

                        // Deshabilitar campos
                        document.getElementById("descripcionTarea").disabled = true;
                        document.getElementById("detallesTarea").disabled = true;

                        // Ocultar botón de guardar
                        document.getElementById("btnGuardarTarea").style.display = "none";

                        const modal = new bootstrap.Modal(document.getElementById("modalAgregarTarea"));
                        modal.show();
                    };

                    tareaElemento.ondragstart = event => {
                        event.dataTransfer.setData("text", JSON.stringify({
                            descripcion: tarea.descripcion,
                            detalles: tarea.detalles,
                            origen: `${boardId}-${columnaId}`
                        }));
                    };

                    contenedor.appendChild(tareaElemento);
                });
            });
        };

        const permitirDrop = (event) => {
            event.preventDefault();
            event.currentTarget.classList.add("over");
        };

        const quitarOver = (event) => {
            event.currentTarget.classList.remove("over");
        };

        const soltarTarea = (event) => {
            event.preventDefault();
            event.currentTarget.classList.remove("over");

            const data = event.dataTransfer.getData("text");
            if (!data) return;

            const { descripcion, detalles, origen } = JSON.parse(data);
            const boardId = obtenerBoardId();
            const destino = event.currentTarget.id;

            const tareasOrigen = JSON.parse(localStorage.getItem(origen)) || [];
            const index = tareasOrigen.findIndex(t => t.descripcion === descripcion);
            if (index > -1) tareasOrigen.splice(index, 1);
            localStorage.setItem(origen, JSON.stringify(tareasOrigen));

            const tareasDestino = JSON.parse(localStorage.getItem(`${boardId}-${destino}`)) || [];
            tareasDestino.push({ descripcion, detalles });
            localStorage.setItem(`${boardId}-${destino}`, JSON.stringify(tareasDestino));

            cargarTareas();
        };

        document.getElementById("btnAgregarTarea").addEventListener("click", () => {
            document.getElementById("descripcionTarea").value = "";
            document.getElementById("detallesTarea").value = "";
            document.getElementById("descripcionTarea").disabled = false;
            document.getElementById("detallesTarea").disabled = false;
            document.getElementById("btnGuardarTarea").style.display = "block";

            const modal = new bootstrap.Modal(document.getElementById("modalAgregarTarea"));
            modal.show();
        });

        document.getElementById("btnGuardarTarea").addEventListener("click", () => {
            const descripcionTarea = document.getElementById("descripcionTarea").value.trim();
            const detallesTarea = document.getElementById("detallesTarea").value.trim();

            if (descripcionTarea === "") {
                alert("Por favor, escribe una descripción válida.");
                return;
            }

            const boardId = obtenerBoardId();
            const tareasPendientes = JSON.parse(localStorage.getItem(`${boardId}-tareasPendientes`)) || [];
            tareasPendientes.push({ descripcion: descripcionTarea, detalles: detallesTarea });
            localStorage.setItem(`${boardId}-tareasPendientes`, JSON.stringify(tareasPendientes));

            cargarTareas();

            const modal = bootstrap.Modal.getInstance(document.getElementById("modalAgregarTarea"));
            modal.hide();
        });

        cargarTareas();
    </script>
</body>

</html>
