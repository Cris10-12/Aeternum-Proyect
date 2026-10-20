<?php
// Menú de navegación. $vista (la vista activa) la define index.php.
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="index.php">Aeternum</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#menuPrincipal" aria-controls="menuPrincipal"
                aria-expanded="false" aria-label="Mostrar u ocultar menú">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ms-auto gap-2 mt-3 mt-lg-0">
                <li class="nav-item">
                    <!-- El botón activo va relleno; el inactivo, solo con borde -->
                    <a class="btn fw-semibold <?= $vista === 'estadisticas' ? 'btn-light' : 'btn-outline-light' ?>"
                       href="index.php?vista=estadisticas">Estadísticas Generales</a>
                </li>
                <li class="nav-item">
                    <a class="btn fw-semibold <?= $vista === 'proyecciones' ? 'btn-light' : 'btn-outline-light' ?>"
                       href="index.php?vista=proyecciones">Proyecciones Futuras</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">