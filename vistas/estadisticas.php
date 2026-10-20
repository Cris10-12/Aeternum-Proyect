<?php
// Vista Estadísticas Generales. Usa $datos, definido en index.php.
$est  = $datos['estadisticas'];
$info = $datos['categorias_info'];
$zona = $datos['zona'];

// Total de registros válidos = suma de los volúmenes por categoría
$totalValidos = 0;
foreach ($est['categorias'] as $cat) {
    $totalValidos += $cat['volumen'];
}
?>
<div class="text-center mb-4">
    <h1 class="h2 mb-1">Estadísticas Generales</h1>
    <p class="text-muted mb-0">Zona de estudio: <?= htmlspecialchars($zona) ?></p>
</div>

<div class="alert alert-info text-center">Datos estáticos de ejemplo, no son mediciones reales.</div>

<!-- Introducción -->
<div class="card mb-4">
    <div class="card-body">
        <h2 class="h5">¿Qué muestra esta página?</h2>
        <p class="mb-0">
            Es un resumen de las lecturas de calidad del aire (material particulado PM2.5) de
            <?= htmlspecialchars($zona) ?>. Cada lectura se clasifica en una de cinco categorías,
            de mejor a peor calidad: Buena, Regular, Media, Baja media y Baja. Abajo se muestra
            cuántas lecturas hay en cada una y qué significa cada categoría.
        </p>
    </div>
</div>

<!-- Tarjetas con los totales -->
<div class="row g-3 mb-4 text-center">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Total de registros de ejemplo</p>
                <p class="display-6 mb-0"><?= htmlspecialchars((string) $est['total_registros']) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Registros válidos</p>
                <p class="display-6 mb-0"><?= htmlspecialchars((string) $totalValidos) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Nulos o lecturas imposibles</p>
                <p class="display-6 mb-0"><?= htmlspecialchars((string) $est['registros_invalidos']) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Tabla por categoría de calidad del aire -->
<div class="card mb-4">
    <div class="card-header fw-semibold">Registros por categoría</div>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th class="text-end">Volumen</th>
                    <th class="text-end">Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($est['categorias'] as $cat): ?>
                    <?php
                    // Color de la etiqueta según la categoría; "orange" usa la variable de Bootstrap
                    $color = $info[$cat['nombre']]['color'] ?? 'secondary';
                    $esNaranja = ($color === 'orange');
                    $porcentaje = $totalValidos > 0 ? $cat['volumen'] / $totalValidos * 100 : 0;
                    ?>
                    <tr>
                        <td>
                            <?php if ($esNaranja): ?>
                                <span class="badge text-dark" style="background-color: var(--bs-orange);"><?= htmlspecialchars($cat['nombre']) ?></span>
                            <?php else: ?>
                                <span class="badge text-bg-<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($cat['nombre']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end"><?= htmlspecialchars((string) $cat['volumen']) ?></td>
                        <!-- El porcentaje se calcula sobre los registros válidos -->
                        <td class="text-end"><?= htmlspecialchars(number_format($porcentaje, 1)) ?> %</td>
                    </tr>
                <?php endforeach; ?>
                <!-- Fila aparte: se excluye de los porcentajes -->
                <tr class="table-secondary">
                    <td>Nulos o lecturas imposibles</td>
                    <td class="text-end"><?= htmlspecialchars((string) $est['registros_invalidos']) ?></td>
                    <td class="text-end">Excluidos</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Explicación de cada categoría -->
<h2 class="h4 text-center mb-3">¿Qué significa cada categoría?</h2>
<div class="row g-3 mb-4">
    <?php foreach ($est['categorias'] as $cat): ?>
        <?php
        $color = $info[$cat['nombre']]['color'] ?? 'secondary';
        $esNaranja = ($color === 'orange');
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <?php if ($esNaranja): ?>
                        <span class="badge text-dark mb-2" style="background-color: var(--bs-orange);"><?= htmlspecialchars($cat['nombre']) ?></span>
                    <?php else: ?>
                        <span class="badge text-bg-<?= htmlspecialchars($color) ?> mb-2"><?= htmlspecialchars($cat['nombre']) ?></span>
                    <?php endif; ?>
                    <p class="mb-0"><?= htmlspecialchars($info[$cat['nombre']]['significado'] ?? '') ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<p class="text-muted text-center small mb-4">
    Las categorías y sus descripciones están pendientes de confirmación con IBOCA/CAR.
</p>

<!-- Contexto oficial reciente sobre la zona -->
<h2 class="h4 text-center mb-3">Contexto reciente en <?= htmlspecialchars($zona) ?></h2>
<div class="row g-3 mb-3 justify-content-center">+

    <?php foreach ($datos['contexto_oficial'] as $c): ?>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1"><?= htmlspecialchars($c['fecha']) ?></p>
                    <h3 class="h6"><?= htmlspecialchars($c['titulo']) ?></h3>
                    <p class="mb-2"><?= htmlspecialchars($c['texto']) ?></p>
                    <p class="text-muted small mb-0">Fuente: <?= htmlspecialchars($c['fuente']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<p class="text-muted text-center small mb-4">
    Resumen redactado a partir de comunicados y notas de prensa sobre la CAR y la Secretaría
    Distrital de Ambiente, ordenado del más reciente al más antiguo.
</p>

<!-- Niveles oficiales del IBOCA y enlace al estado del aire en tiempo real -->
<div class="row justify-content-center mb-4">
    <div class="col-lg-8">
        <div class="card text-center">
            <div class="card-header fw-semibold">Niveles oficiales del IBOCA (referencia)</div>
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nivel</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datos['iboca_referencia'] as $n): ?>
                            <tr>
                                <td><?= htmlspecialchars($n['nivel']) ?></td>
                                <td><?= htmlspecialchars($n['color']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Estos niveles son los del índice oficial de Bogotá y no corresponden aún a las
                    categorías del proyecto, que se confirmarán con IBOCA/CAR.
                </p>
                <a class="btn btn-outline-primary" href="<?= htmlspecialchars($datos['enlace_iboca']) ?>"
                   target="_blank" rel="noopener">Ver el estado del aire en tiempo real (IBOCA)</a>
            </div>
        </div>
    </div>
</div>

<!-- Glosario -->
<div class="card">
    <div class="card-header fw-semibold">Glosario</div>
    <ul class="list-group list-group-flush">
        <?php foreach ($datos['glosario'] as $g): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($g['termino']) ?>:</strong>
                <?= htmlspecialchars($g['definicion']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>