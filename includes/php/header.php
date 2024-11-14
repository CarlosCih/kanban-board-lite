<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                </li>
            </ul>
            <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#newBoardModal">Nuevo Tablero</button>
            <?php endif; ?>
        </div>
    </div>
</nav>
