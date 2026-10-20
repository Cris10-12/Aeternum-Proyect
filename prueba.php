<?php
// Archivo temporal: confirma que el archivo de datos carga completo.
$datos = require __DIR__ . '/data/datos_estaticos.php';
echo 'Categorias: ' . count($datos['categorias_info'])
   . ' | Contexto: ' . count($datos['contexto_oficial'])
   . ' | IBOCA: ' . count($datos['iboca_referencia'])
   . ' | Glosario: ' . count($datos['glosario']);