---------------------------------------------------------------------------------
---------------------------------------------------------------------------------
--------------------------------- BASE DE DATOS ---------------------------------
---------------------------------------------------------------------------------
---------------------------------------------------------------------------------

Ejecutar los siguientes archivos:
- bd.sql
- permisos.sql


---------------------------------------------------------------------------------
---------------------------------------------------------------------------------
--------------------------------- CODIGO FUENTE ---------------------------------
---------------------------------------------------------------------------------
---------------------------------------------------------------------------------

- Reemplazar la carpeta formacioncomunicaciones en "/modules/intranet/modules/"
- El archivo PuntosController.php copiar/reemplazar en "/commands/"
- Configurar tarea programada diariamente para sincronizar puntos asignados en SIICOP. El comando de consola es: 

    <ruta_aplicacion>/yii puntos/sincronizar
    Las sentencias deberían de ser algo como: /var/www/copservir_intranet/yii puntos/sincronizar

- Configuracion de parametros
  
  Al final del archivo params se encuentra el siguiente arreglo
    'formacioncomunicaciones' => [
        'cuestionario' => [
          'opcionesverdaderofalso' => ['1' => 'Verdadero', '0' => 'Falso']
        ],
        'wsSincronizarPuntos' => ''
    ]

  En wsSincronizarPuntos por favor poner la url del servicio del siicop para sincronizar puntos.
  la ruta del webservice es formacionComunicaciones/puntos/sincronizar