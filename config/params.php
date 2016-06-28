<?php

return [
    'adminEmail' => 'admin@example.com',
    'rutaGruposModulos' => '/intranet/sitio/contenido?modulo=',
    'ciudad' => ['*' => 999999],
    'grupo' => ['*' => 999999],
    'calendario' => [
        'dias' => ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "S&aacutebado"],
        'diasAbreviado' => ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        'meses' => [1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"],
        'mesesAbreviado' => [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'],
    ],
    'notificaciones' => [
        'limiteVisualizar' => 5,
        'claseColor' => ['info', 'succes', 'danger']
    ],
    'contenido' => [
        'aniosBusqueda' => 5,
        'imagen' => [
            'ancho' => 1024,//pixeles
            'alto' => 800,//pixeles
            'tamanho' => 1, //Megabytes
            'formatosValidos' => 'jpg,jpeg,png'
        ],
        'archivo' => [
            'tamanho' => 5,
            'formatosValidos' => 'jpg,jpeg,png,pdf'
        ]
    ],
    'documentos' => [
        'rutaArchivo' => '/contenidos/documentos/',
        'rutaDataTables' => 'contenidos/datatable/',
    ],
    'imagenesNoticias' => [
        'limiteVisualizar' => 3
    ],
    'lineasTiempo' => [
        'cumpleanios' => 5,
        'aniversario' => 6
    ],
    'modulosContenido' => [
        '1' => 'Html',
        '2' => 'DataTable',
        '3' => 'Grupos Módulos'
    ],
    'webServices' => [
        'persona' => 'http://localhost/copservir/wsMultiportal/persona',
        //persona' => 'http://sii.copservir.com/gestionhumana/wsMultiportal/persona',
    ]
];
