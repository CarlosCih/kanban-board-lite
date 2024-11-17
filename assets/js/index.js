let editingBoardId = null; // Variable para almacenar el ID del tablero en edición

document.addEventListener("DOMContentLoaded", function() {
    const boardForm = document.getElementById("newBoardForm");
    const boardList = document.getElementById("boardList");
    const emptyState = document.getElementById("emptyState");

    // Ocultar el mensaje de "No tienes tableros aún" al cargar la página
    emptyState.style.display = "none";

    function loadBoards() {
        const boards = JSON.parse(localStorage.getItem("boards")) || [];
        if (boards.length > 0) {
            emptyState.style.display = "none";
            boards.forEach(board => createBoardElement(board));
        } else {
            emptyState.style.display = "block";
        }
    }

    function createBoardElement(board) {
        const boardDiv = document.createElement("div");
        boardDiv.classList.add("col-12", "mb-3");
        boardDiv.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${board.name}</h5>
                    <p class="card-text">${board.description || "Sin descripción"}</p>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm me-2 edit-btn">Editar</button>
                        <button class="btn btn-danger btn-sm me-2 delete-btn">Eliminar</button>
                        <button class="btn btn-secondary btn-sm access-btn">Acceder</button>
                    </div>
                </div>
            </div>
        `;

        const editButton = boardDiv.querySelector(".edit-btn");
        const deleteButton = boardDiv.querySelector(".delete-btn");
        const accessButton = boardDiv.querySelector(".access-btn");

        editButton.addEventListener("click", () => openEditModal(board));
        deleteButton.addEventListener("click", () => deleteBoard(board.id, boardDiv));
        accessButton.addEventListener("click", () => accessBoard(board.id));

        boardList.appendChild(boardDiv);
    }

    function openEditModal(board) {
        editingBoardId = board.id; // Guardar el ID del tablero que se está editando
        document.getElementById("boardName").value = board.name;
        document.getElementById("boardDescription").value = board.description;
        
        // Cambiar el título del modal para indicar que se está editando
        document.getElementById("newBoardModalLabel").innerText = "Editar Tablero";
        
        // Mostrar el modal
        const modalElement = document.getElementById("newBoardModal");
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    }

    function deleteBoard(boardId, boardElement) {
        let boards = JSON.parse(localStorage.getItem("boards")) || [];
        boards = boards.filter(board => board.id !== boardId);
        localStorage.setItem("boards", JSON.stringify(boards));
        boardElement.remove();

        if (boards.length === 0) {
            emptyState.style.display = "block";
        }
    }

    function accessBoard(boardId) {
        localStorage.setItem("currentBoardId", boardId); // Guardar el ID del tablero en localStorage
        window.location.href = `./pages/kanban.php?boardId=${boardId}`;
    }

    boardForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const boardName = document.getElementById("boardName").value;
        const boardDescription = document.getElementById("boardDescription").value;
        
        const boards = JSON.parse(localStorage.getItem("boards")) || [];
        
        if (editingBoardId) {
            // Modo de edición
            const board = boards.find(b => b.id === editingBoardId);
            board.name = boardName;
            board.description = boardDescription;
            
            localStorage.setItem("boards", JSON.stringify(boards));
            boardList.innerHTML = ''; // Limpiar lista
            loadBoards(); // Recargar lista actualizada
            editingBoardId = null; // Reiniciar el modo de edición
        } else {
            // Modo de creación
            if (boardName && boardName.trim() !== "") {
                const newBoard = { 
                    id: Date.now(), 
                    name: boardName, 
                    description: boardDescription 
                };
                boards.push(newBoard);
                localStorage.setItem("boards", JSON.stringify(boards));
                createBoardElement(newBoard);
                emptyState.style.display = "none";
            }
        }

        boardForm.reset();
        
        // Cerrar el modal
        const modalElement = document.getElementById("newBoardModal");
        const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modalInstance.hide();

        // Cambiar el título del modal de nuevo a "Agregar Nuevo Tablero" para la próxima vez
        document.getElementById("newBoardModalLabel").innerText = "Agregar Nuevo Tablero";
    });

    loadBoards();
});
