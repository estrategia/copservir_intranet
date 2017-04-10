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
    'cumpleanios' => [
        'porPagina' => 6,
    ],
    'aniversarios' => [
        'porPagina' => 8,
    ],
    'contenido' => [
        'diasNoticias' => 7,
        'aniosBusqueda' => 5,
        'imagen' => [
            'ancho' => 1024,//pixeles
            'alto' => 800,//pixeles
            'tamanho' => 1, //Megabytes
            'formatosValidos' => 'jpg,jpeg,png',
            'calidadJPG' => 90, // De 0 a 100, siendo 100 la mayor calidad pero tambien la imagen mas pesada, valido para jpg
            'compresionPNG' => 5 // De 0 a 9, siendo 9 el archivo mas pequeño pero el que mas demora para comprimir, valido para png
        ],
        'archivo' => [
            'tamanho' => 5,
            'formatosValidos' => 'jpg,jpeg,png,pdf'
        ],
        'imagenAdmin' => [
            'ancho' => 1920,//pixeles
            'alto' => 1280,//pixeles
            'tamanho' => 3, //Megabytes
            'formatosValidos' => 'jpg,jpeg,png'
        ],
        'archivoAdmin' => [
            'tamanho' => 6,
            'formatosValidos' => 'jpg,jpeg,png,pdf'
        ],
        
    ],
    'documentos' => [
        'rutaArchivo' => '/contenidos/documentos/',
        'rutaDataTables' => 'contenidos/datatable/',
    ],
    'imagenesNoticias' => [
        'limiteVisualizar' => 3
    ],
    'imagenesModuloGaleria' => [
        'limiteVisualizar' => 3
    ],
    'longitudResumenNoticias' => [
        'intranet' => 300,
        'portales' => 120,
    ],
    'lineasTiempo' => [
        'cumpleanios' => 5,
        'aniversario' => 6
    ],
    'modulosContenido' => [
        '1' => 'Html',
        '2' => 'DataTable',
        '3' => 'Grupos Módulos',
        '4' => 'DataTable Cedula',
        '5' => 'Galeria Imágenes',
    ],
    'PerfilesUsuario' => [
        'intranet' => ['codigo' => 1, 'permiso' => 'intranet_usuario'],
        'tarjetaMas' => ['codigo' => 2, 'permiso' => 'tarjetamas_usuario'],
        'visitaMedica' => ['codigo' => 3, 'permiso' => ''],

    ],
    'webServices' => [
        'codigoSeguridad' => 'CopservirLaMejorEmpresaParaTrabajar2016',
        'tarjetaMas' => 'http://siidesarrollo.copservir.com/tarjetamas/WsTarjetaMas/ws',
        //'tarjetaMas' => 'http://sii.copservir.com/tarjetamas/WsTarjetaMas/ws',
        'persona' => 'http://localhost/copservir/wsMultiportal/persona',
        // 'persona' => 'http://192.168.1.22/copservir/wsMultiportal/persona',
        //'persona' => 'http://sii.copservir.com/gestionhumana/wsMultiportal/persona',
        'tradeMarketing' => [
          'puntosVenta' => 'http://localhost/copservir/puntoventa/sweb/puntoventa',
          'unidades' => 'http://localhost/copservir/trademarketing/wsTradeMarketing/unidades'
        ],
        // 'lrv' => 'http://192.168.1.22/lrv/rest',
        // 'lrv' => 'http://localhost/lrv/rest',
        'lrv' => 'https://www.larebajavirtual.com/rest',

    	'visitaMedica' => [
            // 'detallePDV' => 'http://localhost/lrv/rest/producto/simular',
    		'detallePDV' => 'http://siidesarrollo.copservir.com:8080/WebSaldosVisitaMedica/webresources/service/saldos',
    	],
        'productos' => [
            'terceros' => 'http://localhost/copservir/productos/sweb/terceros',
        ],
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
    'tradeMarketing' => [
        'directorioCargues' => '/uploads/trademarketing/'		
    ],
    'visitamedica' => [
        'session' => [
            'ubicacion' => [
                'ciudad' => 'visitamedica.ubicacion.ciudad',
                'nombreCiudad' => 'visitamedica.ubicacion.nombreCiudad',
                'sector' => 'visitamedica.ubicacion.sector',
                'nombreSector' => 'visitamedica.ubicacion.nombreSector',
            ],
            'filtrosUsuario' => 'visitamedica.filtrosUsuario',
            'nitLaboratorio' => 'visitamedica.reportes.nitLaboratorio'
        ],
    ],
    'portales' => [
        'session' => [
            'logoPortal',
            'colorPortal'
        ]
    ],
    'google' => [
        'llaveMapa' => 'gme-copservir'
    ],
    'habeasDataLink' => 'hola',
    'portales' => [
        'proveedores' => [
            'servicios-publicos' => [
                'Información General' => 'proveedores_usuario',
                'Actividades Comerciales' => 'proveedores_actividades-comerciales',
                'Certificados Tributarios' => 'proveedores_certificados-tributarios',
                'Mis Productos' => 'proveedores_mis-productos',
                'Informe de Ventas' => 'proveedores_informe-ventas',
                'Cita Entrega de Mercancia' => 'proveedores_citas-mercancia',
            ],
            'servicios-privados' => [
                'Visita Médica' => 'visitaMedica_visitador',
            ],
            // Lista de servicios privados, que pueden ser autorizados para acceso por algun rol
            'servicios-permisos' => [
                'visitaMedica_admin' => [
                    'visitaMedica_visitador',
                ],
                
            ]
        ]
    ],
		'formacioncomunicaciones' => [
				'cuestionario' => [
				'opcionesverdaderofalso' => ['1' => 'Verdadero', '0' => 'Falso']
			]
		]
		


];
