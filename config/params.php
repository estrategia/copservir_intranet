<?php

return [
    'adminEmail' => 'webmaster@copservir.com',
    'rutaGruposModulos' => '/intranet/sitio/contenido?modulo=',
    'limiteBotonesPaginador' => 5,
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
        'claseColor' => ['info', 'success', 'danger']
    ],
    'contenido' => [
        'diasNoticias' => 7,
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
        '3' => 'Grupos Módulos',
        '4' => 'DataTable Cedula'
    ],
    'PerfilesUsuario' => [
        'intranet' => ['codigo' => 1, 'permiso' => 'intranet_usuario'],
        'tarjetaMas' => ['codigo' => 2, 'permiso' => 'tarjeta_mas_usuario'],
        'visitaMedica' => ['codigo' => 3, 'permiso' => ''],

    ],
    'webServices' => [
        'codigoSeguridad' => 'CopservirLaMejorEmpresaParaTrabajar2016',
        'tarjetaMas' => 'http://siidesarrollo.copservir.com/tarjetamas/WsTarjetaMas/ws',
        //'tarjetaMas' => 'http://sii.copservir.com/tarjetamas/WsTarjetaMas/ws',
        'persona' => 'http://localhost/copservir/wsMultiportal/persona',
        //'persona' => 'http://sii.copservir.com/gestionhumana/wsMultiportal/persona',
        'tradeMarketing' => [
          'puntosVenta' => 'http://localhost/copservir/puntoventa/sweb/puntoventa',
          'unidades' => 'http://localhost/copservir/tradeMarketing/wsTradeMarketing/unidades'
        ],
        'lrv' => 'http://localhost/lrv/rest'
    ],
    'usuario' => [
      'tiempoRecuperarClave' => 1 // dias
    ],
    'cargos' => [
      'cargosBuscadorAdmin' => [
        '0010', //PRESIDENTE
        '001101', //GERENTE COMERCIAL
        '001102', //GERENTE DE LOGISTICA
        '001103', //GERENTE OPERATIVO
        '001104', //GERENTE DE MERCADEO
        '001105', //GERENTE DE VENTAS
        '001106', //GERENTE DE TECNOLOGIA
        '001107', //GERENTE DE SERVICIOS COOPERATIVOS AL ASOCIADO
        '001108', //GERENTE DE AUDITORIA OPERATIVA
        '001109', //GERENTE DE RELACIONES LABORALES
        '001110', //GERENTE DE SELECCION Y DESARROLLO
        '001111', //GERENTE DE INFRAESTRUCTURA
        '001112', //GERENTE DE SERVICIOS ADMINISTRATIVOS
        '001113', //GERENTE DE TESORERIA
        '001114', //GERENTE DE ASUNTOS CORPORATIVOS
        '001115', //GERENTE DE PLANEACION Y RIESGOS
        '001116', //GERENTE DE CONTABILIDAD E IMPUESTOS
        '001117', //GERENTE DE AUDITORIA DE PROCESOS
        '001118', //GERENTE DE AUDITORIA DE SISTEMAS Y TECNOLOGIA
        '001119', //GERENTE DE BIENESTAR LABORAL
        '001201', //DIRECTOR JURIDICO
        '001202', //DIRECTOR DE ZONA
        '001203', //DIRECTOR DE LOGISTICA PUNTOS DE VENTA
        '001204', //DIRECTOR DE LOGISTICA CEDIS
      ]
    ],
    'visitamedica' => [
        'session' => [
            'ubicacion' => [
                'ciudad' => 'visitamedica.ubicacion.ciudad',
                'nombreCiudad' => 'visitamedica.ubicacion.nombreCiudad',
                'sector' => 'visitamedica.ubicacion.sector',
                'nombreSector' => 'visitamedica.ubicacion.nombreSector',
                ''
            ],
            'filtrosUsuario' => 'visitamedica.filtrosUsuario',
        ],
    ],
    'google' => array(
        'llaveMapa' => 'gme-copservir'
    ),

];
