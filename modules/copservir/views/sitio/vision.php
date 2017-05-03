<?php
use yii\helpers\Html;
$this->title = 'Visión';

// Rutas imagenes
$srcMision = Yii::$app->homeUrl . 'img/multiportal/copservir/nuestra-vision.jpg';
?>
    <!-- Migas de pan
    ================================================== -->


    <div class="page-header">
      <div class="container">
        <div class="page-title">
          <h1>Nuestra Visión</h1>
          <div class="breadcrumbs"><?= Html::a('Inicio', ['/copservir']) ?>  / Nuestra visión</div>
        </div>
      </div>
    </div>

    <div class="container internal">
        <img class="img-responsive" style="border-radius: 10px;" src=<?= "" . $srcMision ?> alt="">
         <div class="space-2"></div>
      <p>
         En Copservir nos proyectamos para continuar consolidándonos como una institución reconocida en el sector solidario, que propende por el bienestar y el desarrollo de sus asociados y familias, contribuyendo al mejoramiento de su calidad de vida, mediante la prestación de servicios integrales y comercialización de  productos que generan beneficios a  toda la comunidad.  Una institución que trabaja por la generación de capital social, pero sin desdibujar su objetivo principal, el desarrollo personal y profesional de sus asociados- trabajadores, participando en la construcción de mayores y mejores condiciones de bienestar para estos, sus familias y la comunidad.
      </p>
      <div class="space-2"></div>
    </div>
      <div class="gray-sec">
        <div class="container internal">
          <div class="col-sm-12">
            <div class="white-item">
              <h3>Visión</h3>
              <p>Ser la empresa solidaria competitiva en servicio y sostenible para el bienestar de la comunidad (Asociados – Clientes). <p>
            </div>
          </div>
        </div>
      </div>
      <div class="space-1"></div>
    <div class="space-2"></div>
