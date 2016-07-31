<?php
use app\modules\intranet\models\Funciones;

$idItem = '';
if ($location == 0) {
  $idItem = 'bannerArriba';
}else if ($location == 1) {
  $idItem = 'bannerAbajo';
}if ($location == 2) {
  $idItem = 'bannerLateral';
}
?>

<div id="<?= $idItem ?>" class="carousel slide" data-ride="carousel">

  <div class="carousel-inner" role="listbox">

    <?php $contador = 0 ?>

    <?php foreach ($banners as $banner): ?>
      <div id="<?= $idItem.$contador  ?>" class="item">
          <?php Funciones::getHtmlLink($banner['urlEnlaceNoticia'],"<img class='img-responsive' src='".Yii::$app->homeUrl . "img/campanas/".$banner['rutaImagen']."' alt=''>"); ?>
      </div>
      <?php  $contador++; ?>
    <?php endforeach; ?>
  </div>

  <?php if (count($banners) > 1 ): ?>

    <a class="left carousel-control" href="#<?= $idItem ?>" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#<?= $idItem ?>" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>

  <?php endif; ?>
</div>
