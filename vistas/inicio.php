<?php
// Vista de bienvenida. Es la vista por defecto de index.php.
?>
<div class="p-5 mb-4 bg-white border rounded-3 text-center">
    <h1 class="display-5 mb-3">Bienvenido a Aeternum</h1>
    <p class="lead">
        Aeternum es un proyecto de predicción de la calidad del aire a partir del
        material particulado PM2.5.
    </p>
    <p class="text-muted">
        Este prototipo tiene dos vistas: Estadísticas Generales, con el resumen de
        registros por categoría de calidad del aire, y Proyecciones Futuras, con la
        calidad esperada a 6 horas, 12 horas, 1 día y 1 semana. Todos los datos son
        estáticos de ejemplo, sin modelo de Machine Learning.
    </p>
    <a class="btn btn-primary btn-lg" href="index.php?vista=estadisticas">Comenzar</a>
</div>