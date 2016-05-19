<?php
use yii\helpers\Html;

$this->title = 'Proveedores';

// Rutas imagenes
$srcProveedor = Yii::$app->homeUrl . 'img/multiportal/proveedores/proveedores.png';
?>
<img src=<?= "" . $srcProveedor ?> alt="">

<div class="space-2"></div>

<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container internal text-left">
  <section>  <!-- acerca de home -->
    <div class="acerca-home">
      <h1>Bienvenido a nuestra compañía</h1>
      <div class="space-1"></div>
      <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare commodo sagittis. Quisque cursus, nisi a bibendum posuere, nisl dolor egestas eros, vitae feugiat ipsum ipsum eget sapien. Fusce laoreet bibendum accumsan. Sed dui odio, elementum sit amet ligula eu, porta pharetra leo. Nunc sed velit imperdiet, rutrum quam at, pulvinar velit.</p>
      <div class="space-1"></div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <div class="white-item">
          <div class="default-icon left-icon big-icon company-bgcolor-1"></div>
          <h3>Descarga tus certificados de retención en línea</h3>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="white-item">
          <div class="default-icon left-icon big-icon company-bgcolor-1"></div>
          <h3>Quiero ser proveedor</h3>
          <p>Inicia una relacón comercial con nosotros.</p>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="white-item">
          <div class="default-icon left-icon big-icon company-bgcolor-1"></div>
          <h3>Iniciar sessión</h3>
          <p>Lorem ipsum is dolor sit ammet.</p>
        </div>
      </div>
    </div>

  </section> <!-- / acerca de home -->
</div>

<div class="space-2"></div>

<div class="space-2"></div>

<div class="space-2"></div>
<!-- -->
<?php
  echo $this->render('//common/_ultimasNoticias', [
    'contenidoModels' => $contenidoModels,
    'flagVerMas' => $flagVerMas,
  ]);
?>
<div class="space-2"></div>
<!-- ALIADOS -->
<?= $this->render('//common/_portales', []) ?>
<div class="space-1"></div>
<!-- /ALIADOS -->
