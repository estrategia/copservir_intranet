<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\Usuario */

$this->title = 'Ayuda';
$this->params['breadcrumbs'][] = $this->title;
$carpeta = Url::to('@web/img/multiportal/proveedores/ayuda-vimed', true);
?>
<div class="row text-center">
  <h1>Sección de ayuda</h1>
</div>
<div class="separator col-md-10 col-md-offset-1"></div>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
  <h3>Selección de ubicación</h3>
      <div id="help-ubicacion" data-chocolat-title="Seleccion de ubicación">
        <a class="chocolat-image" href="<?= $carpeta.'/ubicacion1.png' ?>" title="Al ingresar a la aplicacón, se le solicitara seleccionar su ubicación." >
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/ubicacion1.png' ?>" alt="Ubicacion1">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/ubicacion2.png' ?>" title="Si presiona el botón 'GPS' la aplicación detectara automaticamente su ubicación. Solo debera confirmarla presionando el botón aceptar del diálogo que aparece">
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/ubicacion2.png' ?>" alt="Ubicacion2">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/ubicacion3.png' ?>" title="Si presiona el botón 'Mapa' se desplegara un mapa en el que puede seleccionar su ubicación arrastrando el marcador o seleccionar la ciudad en el desplegable superior">
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/ubicacion3.png' ?>" alt="Ubicacion3">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/ubicacion4.png' ?>" title="Si selecciono la ciudad con el desplegable superior, aparecera otro desplegable para seleccionar el sector en el que se encuentra">
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/ubicacion4.png' ?>" alt="Ubicacion4">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/ubicacion5.png' ?>" title="Al seleccionar el sector, el mapa se ubicara automaticamente en este, haciendo zoom">
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/ubicacion5.png' ?>" alt="Ubicacion5">
        </a>
      </div>
    </div>
</div>
<br>
<div class="separator col-md-10 col-md-offset-1"></div>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <h3>Consulta de productos</h3>
      <div id="help-consulta" data-chocolat-title="Consulta de productos">
        <a class="chocolat-image" href="<?= $carpeta.'/consulta1.png' ?>" title="Despues de seleccionar una ubicación, podra hacer uso de la busqueda de productos. Puede digitar el nombre del producto en la caja de texto y presionar buscar" >
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/consulta1.png' ?>" alt="consulta1">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/consulta2.png' ?>" title="Al buscar un termino se desplegara una lista de posibles resultados. Si desea visualizar el detalle de un producto debe presionar el boton que aparece en la columna mapa." >
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/consulta2.png' ?>" alt="consulta2">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/consulta3.png' ?>" title="Se muestra informacion referente al producto y a los puntos de venta en los que se encuentra disponible, mostrando información de precios, disponibilidad y ubicandolos en un mapa">
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/consulta3.png' ?>" alt="consulta3">
        </a>
      </div>
    </div>
</div>
<br>
<div class="separator col-md-10 col-md-offset-1"></div>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <h3>Consulta de reportes</h3>
      <div id="help-reportes" data-chocolat-title="Consulta de reportes">
        <a class="chocolat-image" href="<?= $carpeta.'/reportes1.png' ?>" title="La aplicación permite generar 2 tipos de reporte, de accesos a la aplicacion y de consulta de productos" >
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/reportes1.png' ?>" alt="reportes1">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/reportes2.png' ?>" title="Se generan diferentes graficas por periodo de tiempo para mostrar el registro de accesos a la aplicación, asi como un registro detallado del lugar, fecha y direccion ip desde donde se realizo la conexión" >
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/reportes2.png' ?>" alt="reportes2">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/reportes3.png' ?>" title="Se muestra información sobre la busqueda de productos como la cantidad de busquedas y la persona que las realizo.">
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/reportes3.png' ?>" alt="consulta3">
        </a>
      </div>
    </div>
</div>
<br>
<div class="separator col-md-10 col-md-offset-1"></div>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <h3>Mi cuenta</h3>
      <div id="help-mi-cuenta" data-chocolat-title="Mi cuenta">
        <a class="chocolat-image" href="<?= $carpeta.'/mi-cuenta1.png' ?>" title="Se muestra toda la información referente a la persona que esta autenticada en la aplicación" >
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/mi-cuenta1.png' ?>" alt="mi-cuenta1">
        </a>
        <a class="chocolat-image" href="<?= $carpeta.'/mi-cuenta2.png' ?>" title="Se permite la edicion de algunos campos de informacion personal" >
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/mi-cuenta2.png' ?>" alt="reportes2">
        </a>
      </div>
    </div>
</div>
<br>
<div class="separator col-md-10 col-md-offset-1"></div>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <h3>Contacto</h3>
      <div id="help-contacto" data-chocolat-title="Contacto">
        <a class="chocolat-image" href="<?= $carpeta.'/contacto.png' ?>" title="En este apartado se permite al usuario logueado enviar un correo directamente al usuario administrador del laboratorio" >
            <img class="img-thumbnail col-md-6" src="<?= $carpeta.'/contacto.png' ?>" alt="mi-cuenta1">
        </a>
      </div>
    </div>
</div>
<br>
<div class="separator col-md-10 col-md-offset-1"></div>