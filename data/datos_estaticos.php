<?php
// Datos estáticos de ejemplo para el prototipo Aeternum (T-06).
// Todos los valores están escritos a mano; no hay base de datos ni cálculo de predicciones.
// En el Sprint 2 este archivo se reemplazará por datos reales.

return [

    // Zona de estudio del proyecto
    'zona' => 'Mochuelo Bajo',


    // Contexto oficial reciente sobre Mochuelo (resumen redactado a mano a partir de las fuentes).
    // Ordenado de lo más reciente a lo más antiguo. Todas las fechas fueron verificadas.
    'contexto_oficial' => [
        [
            'fecha'  => '25 de junio de 2026',
            'titulo' => 'Mochuelo declarado Área Fuente de Contaminación Atmosférica Clase I',
            'texto'  => 'La CAR declaró a Mochuelo Alto y Mochuelo Bajo en la categoría más alta de contaminación atmosférica de la normativa ambiental (Resolución 191 de junio de 2026). La medida dura diez años y se basa en nueve años de datos de PM2.5, con picos en 2022, 2024, 2025 y 2026.',
            'fuente' => 'El Tiempo y El Dorado Radio (con base en la CAR)',
        ],
        [
            'fecha'  => '13 de marzo de 2026',
            'titulo' => 'Mejora por lluvias en estaciones cercanas',
            'texto'  => 'La Secretaría de Ambiente informó un descenso de contaminantes en las estaciones de Usme, Ciudad Bolívar y Tunal desde el 6 de marzo, por más lluvias y cambios en el viento. En los primeros seis días del mes había aumentado el material particulado en el sur de Bogotá.',
            'fuente' => 'Secretaría Distrital de Ambiente (bogota.gov.co)',
        ],
        [
            'fecha'  => '7 de marzo de 2026',
            'titulo' => 'Dos autoridades en el territorio',
            'texto'  => 'El 92 % de Mochuelo está bajo competencia de la CAR y el 8 % restante, principalmente urbano, bajo la Secretaría Distrital de Ambiente. En ese 8 % las mediciones recientes han mostrado niveles entre bajos y moderados.',
            'fuente' => 'Secretaría Distrital de Ambiente (bogota.gov.co)',
        ],
        [
            'fecha'  => '4 de marzo de 2026',
            'titulo' => 'Segunda alerta preventiva en menos de un mes',
            'texto'  => 'La CAR volvió a declarar la alerta preventiva en Mochuelo por nuevas concentraciones elevadas de PM2.5. La medida anterior se había levantado ocho días antes.',
            'fuente' => 'Blu Radio',
        ],
        [
            'fecha'  => '14 de febrero de 2026',
            'titulo' => 'Alerta preventiva de la CAR',
            'texto'  => 'La CAR declaró alerta preventiva por mala calidad del aire en Mochuelo tras registrar niveles altos de PM2.5. Recomendó reducir la actividad física intensa al aire libre y estar atentos a los reportes oficiales.',
            'fuente' => 'Minuto60 (con base en la CAR)',
        ],
    ],
    // Niveles oficiales del IBOCA, solo como referencia (no se usan para clasificar los datos).
    'iboca_referencia' => [
        ['nivel' => 'Favorable', 'color' => 'Verde'],
        ['nivel' => 'Moderada',  'color' => 'Amarillo'],
        ['nivel' => 'Regular',   'color' => 'Naranja'],
        ['nivel' => 'Mala',      'color' => 'Rojo'],
        ['nivel' => 'Peligrosa', 'color' => 'Morado'],
    ],

    // Enlace oficial para consultar el estado del aire en tiempo real
    'enlace_iboca' => 'http://iboca.ambientebogota.gov.co/mapa/',

    // Descripción de cada categoría de calidad del aire (se confirmarán con IBOCA/CAR).
    // Las recomendaciones son orientativas y generales; no corresponden a normativa.
    'categorias_info' => [
        'Buena' => [
            'significado' => 'El aire tiene una concentración baja de partículas finas. Es el mejor escenario para la zona.',
            'recomendacion' => 'Se puede salir y hacer actividades al aire libre con normalidad.',
            'color' => 'success',
        ],
        'Regular' => [
            'significado' => 'La concentración de partículas es aceptable, aunque ya no es la mejor.',
            'recomendacion' => 'Se puede salir con normalidad. Las personas muy sensibles pueden notar molestias leves.',
            'color' => 'info',
        ],
        'Media' => [
            'significado' => 'La concentración de partículas empieza a ser relevante para personas sensibles.',
            'recomendacion' => 'Niños, adultos mayores y personas con problemas respiratorios deberían reducir el ejercicio intenso al aire libre.',
            'color' => 'warning',
        ],
        'Baja media' => [
            'significado' => 'La calidad del aire es deficiente y puede afectar a una parte importante de la población.',
            'recomendacion' => 'Conviene limitar el tiempo y el ejercicio al aire libre, sobre todo en grupos sensibles.',
            'color' => 'orange',
        ],
        'Baja' => [
            'significado' => 'La calidad del aire es la peor de las cinco categorías.',
            'recomendacion' => 'Se recomienda evitar actividades al aire libre y permanecer en espacios cerrados cuando sea posible.',
            'color' => 'danger',
        ],
    ],

    // Glosario breve para la vista Estadísticas Generales
    'glosario' => [
        ['termino' => 'PM2.5',      'definicion' => 'Partículas en el aire de tamaño muy pequeño, lo bastante finas para entrar a las vías respiratorias.'],
        ['termino' => 'Registro',   'definicion' => 'Una lectura de calidad del aire tomada en un momento determinado.'],
        ['termino' => 'Categoría',  'definicion' => 'Grupo en el que se clasifica una lectura según qué tan limpio o contaminado está el aire.'],
        ['termino' => 'Volumen',    'definicion' => 'Cantidad de registros que pertenecen a una categoría.'],
        ['termino' => 'Porcentaje', 'definicion' => 'Parte que representa una categoría sobre el total de registros válidos.'],
        ['termino' => 'Registro nulo o con lectura imposible', 'definicion' => 'Lectura vacía o con un valor que no puede ser real; se excluye de los porcentajes.'],
    ],

    // Datos para la vista Estadísticas Generales
    'estadisticas' => [
        // Total de registros de ejemplo (incluye los nulos o con lecturas imposibles)
        'total_registros' => 1000,

        // Registros válidos por categoría (volumen). El porcentaje se calcula en la vista.
        'categorias' => [
            ['nombre' => 'Buena',       'volumen' => 300],
            ['nombre' => 'Regular',     'volumen' => 250],
            ['nombre' => 'Media',       'volumen' => 200],
            ['nombre' => 'Baja media',  'volumen' => 120],
            ['nombre' => 'Baja',        'volumen' => 80],
        ],

        // Registros nulos o con lecturas imposibles (se excluyen de los porcentajes)
        'registros_invalidos' => 50,
    ],

    // Datos para la vista Proyecciones Futuras (texto fijo, sin modelo de ML)
    'proyecciones' => [
        '6h' => [
            'etiqueta' => '6 horas',
            'calidad'  => 'Regular',
            'pm25'     => '22 µg/m³',
        ],
        '12h' => [
            'etiqueta' => '12 horas',
            'calidad'  => 'Media',
            'pm25'     => '28 µg/m³',
        ],
        '1d' => [
            'etiqueta' => '1 día',
            'calidad'  => 'Media',
            'pm25'     => '31 µg/m³',
        ],
        '1s' => [
            'etiqueta' => '1 semana',
            'calidad'  => 'Baja media',
            'pm25'     => '36 µg/m³',
        ],
    ],

];