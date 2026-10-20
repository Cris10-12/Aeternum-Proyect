<?php
// Vista Proyecciones Futuras. Usa $datos, definido en index.php.
$proyecciones = $datos['proyecciones'];
$info         = $datos['categorias_info'];
$zona         = $datos['zona'];
?>
<div class="text-center mb-4">
    <h1 class="h2 mb-1">Proyecciones Futuras</h1>
    <p class="text-muted mb-0">Zona de estudio: <?= htmlspecialchars($zona) ?></p>
</div>

<!-- Aviso obligatorio: los valores son texto fijo -->
<div class="alert alert-warning text-center">Datos estáticos de ejemplo, sin modelo de Machine Learning</div>

<!-- Introducción -->
<div class="row justify-content-center mb-4">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="h5">¿Qué muestra esta página?</h2>
                <p class="mb-2">
                    Muestra cómo se espera que sea la calidad del aire en
                    <?= htmlspecialchars($zona) ?> dentro de 6 horas, 12 horas, 1 día y 1 semana.
                    Elige un plazo en las pestañas para ver el detalle.
                </p>
                <p class="text-muted small mb-0">
                    Nivel de calidad esperado: la categoría en la que se espera que esté el aire.
                    PM2.5 de ejemplo: la concentración de partículas finas en el aire,
                    medida en microgramos por metro cúbico (µg/m³).
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Botones de las pestañas (nav-pills), centrados -->
<ul class="nav nav-pills justify-content-center mb-3" id="pestanasProyeccion" role="tablist">
    <?php $primera = true; ?>
    <?php foreach ($proyecciones as $clave => $p): ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $primera ? 'active' : '' ?>"
                    id="pestana-<?= htmlspecialchars($clave) ?>"
                    data-bs-toggle="pill"
                    data-bs-target="#panel-<?= htmlspecialchars($clave) ?>"
                    type="button" role="tab"
                    aria-controls="panel-<?= htmlspecialchars($clave) ?>"
                    aria-selected="<?= $primera ? 'true' : 'false' ?>">
                <?= htmlspecialchars($p['etiqueta']) ?>
            </button>
        </li>
        <?php $primera = false; ?>
    <?php endforeach; ?>
</ul>

<!-- Contenido de cada pestaña -->
<div class="tab-content mb-4">
    <?php $primera = true; ?>
    <?php foreach ($proyecciones as $clave => $p): ?>
        <?php
        // Datos de la categoría esperada; "orange" usa la variable de Bootstrap
        $color     = $info[$p['calidad']]['color'] ?? 'secondary';
        $esNaranja = ($color === 'orange');
        ?>
        <div class="tab-pane fade <?= $primera ? 'show active' : '' ?>"
             id="panel-<?= htmlspecialchars($clave) ?>"
             role="tabpanel"
             aria-labelledby="pestana-<?= htmlspecialchars($clave) ?>">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card text-center">
                        <div class="card-header fw-semibold">Proyección a <?= htmlspecialchars($p['etiqueta']) ?></div>
                        <div class="card-body">
                            <p class="text-muted mb-1">Nivel de calidad esperado</p>
                            <p class="mb-3">
                                <?php if ($esNaranja): ?>
                                    <span class="badge fs-4 text-dark" style="background-color: var(--bs-orange);"><?= htmlspecialchars($p['calidad']) ?></span>
                                <?php else: ?>
                                    <span class="badge fs-4 text-bg-<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($p['calidad']) ?></span>
                                <?php endif; ?>
                            </p>
                            <p class="text-muted mb-1">PM2.5 de ejemplo</p>
                            <p class="h3 mb-4"><?= htmlspecialchars($p['pm25']) ?></p>

                            <hr>

                            <p class="fw-semibold mb-1">¿Qué significa?</p>
                            <p><?= htmlspecialchars($info[$p['calidad']]['significado'] ?? '') ?></p>

                            <p class="fw-semibold mb-1">¿Es seguro salir?</p>
                            <p class="mb-0"><?= htmlspecialchars($info[$p['calidad']]['recomendacion'] ?? '') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $primera = false; ?>
    <?php endforeach; ?>
</div>

<!-- Guía de todos los niveles -->
<h2 class="h4 text-center mb-3">Guía de los niveles de calidad del aire</h2>
<div class="row g-3 justify-content-center mb-3">
    <?php foreach ($info as $nombre => $c): ?>
        <?php $esNaranja = ($c['color'] === 'orange'); ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <?php if ($esNaranja): ?>
                        <span class="badge text-dark mb-2" style="background-color: var(--bs-orange);"><?= htmlspecialchars($nombre) ?></span>
                    <?php else: ?>
                        <span class="badge text-bg-<?= htmlspecialchars($c['color']) ?> mb-2"><?= htmlspecialchars($nombre) ?></span>
                    <?php endif; ?>
                    <p class="small mb-2"><?= htmlspecialchars($c['significado']) ?></p>
                    <p class="small text-muted mb-0"><?= htmlspecialchars($c['recomendacion']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<p class="text-muted text-center small mb-0">
    Las recomendaciones son orientativas y están pendientes de confirmación con IBOCA/CAR.
    No reemplazan indicaciones de autoridades ambientales ni de salud.
</p>