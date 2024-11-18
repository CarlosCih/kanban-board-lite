<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="http://localhost/kanban-board-lite/">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <!-- Enlaces adicionales -->
                </li>
            </ul>
            <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#newBoardModal">
                    <i class="bi bi-plus-circle"></i> Nuevo Tablero
                </button>
            <?php endif; ?>
            <button class="btn btn-outline-secondary" id="themeToggle">
                <i class="bi bi-moon"></i> Tema Oscuro
            </button>
        </div>
    </div>
</nav>

<script>
// Seleccionamos el botón de cambio de tema y el body
const themeToggleButton = document.getElementById('themeToggle');
const body = document.body;

// Comprobar si el tema oscuro ya está guardado en localStorage
if (localStorage.getItem('dark-theme') === 'enabled') {
    body.classList.add('dark-theme');
    themeToggleButton.innerHTML = '<i class="bi bi-sun"></i> Tema Claro';
}

// Añadir un evento de clic al botón para cambiar entre tema claro y oscuro
themeToggleButton.addEventListener('click', () => {
    // Cambiar entre clases para el tema
    body.classList.toggle('dark-theme');

    // Cambiar el ícono y el texto del botón
    if (body.classList.contains('dark-theme')) {
        themeToggleButton.innerHTML = '<i class="bi bi-sun"></i> Tema Claro';
        localStorage.setItem('dark-theme', 'enabled'); // Guardar preferencia en el almacenamiento local
    } else {
        themeToggleButton.innerHTML = '<i class="bi bi-moon"></i> Tema Oscuro';
        localStorage.removeItem('dark-theme'); // Eliminar preferencia de tema
    }
});
</script>
