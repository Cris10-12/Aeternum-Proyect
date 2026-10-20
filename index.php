<?php
// Enrutador simple de Aeternum. Único punto de entrada de la aplicación.

// Lista blanca: solo estas vistas se pueden abrir. Clave = valor de ?vista=, valor = título.
$vistasPermitidas = [
    'inicio'       => 'Bienvenida',
    'estadisticas' => 'Estadísticas Generales',
    'proyecciones' => 'Proyecciones Futuras',
];

// Lee ?vista= y, si no es texto o no está en la lista blanca, usa la bienvenida.
$vista = $_GET['vista'] ?? 'inicio';
if (!is_string($vista) || !array_key_exists($vista, $vistasPermitidas)) {
    $vista = 'inicio';
}

// Título que usa header.php
$titulo = $vistasPermitidas[$vista];

// Datos estáticos de ejemplo, disponibles como $datos en las vistas
$datos = require __DIR__ . '/data/datos_estaticos.php';

// Se arma la página con los fragmentos y la vista elegida
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
require __DIR__ . '/vistas/' . $vista . '.php';
require __DIR__ . '/includes/footer.php';