<?php
use app\modules\intranet\models\Funciones;

$idItem = '';
if ($location == 0) {
  $idItem = 'bannerArriba';
}else if ($location == 1) {
  $idItem = 'bannerAbajo';
}else if ($location == 2) {
  $idItem = 'bannerLateral';
}else if ($location == 3) {
  $idItem = 'bannerArriba';
}

$userCedula = Yii::$app->user->identity->numeroDocumento;
//$userNombreCompleto = Yii::$app->user->identity->nombres." ".Yii::$app->user->identity->primerApellido." ".Yii::$app->user->identity->segundoApellido;
$userNombreCompleto = Yii::$app->user->identity->nombres;

$rutaArchivo = Yii::getAlias('@webroot') . "/emisora/cedula_vendedores.csv";
$separador = ",";
$array_lrv = array();
$existe = false;
if(($handle = fopen("$rutaArchivo", "r")) !== false)
{
	while(($datos = fgetcsv($handle, 0, $separador)) !== false){
		$array_lrv[$datos[0]] = $datos;
		if(trim($datos[0]) == $userCedula){
			$existe=true;
			break;
		}
	}
	fclose($handle);
}
?>

<div id="<?= $idItem ?>" class="carousel slide" data-ride="carousel">

  <div class="carousel-inner" role="listbox">
    <?php $contador = 0 ?>
    <?php foreach ($banners as $banner): ?>
      <div id="<?= $idItem.$contador  ?>" class="item">
          <?php Funciones::getHtmlLink($banner['urlEnlaceNoticia'],"<img class='img-responsive visible-xs visible-sm' src='".Yii::$app->homeUrl . "img/campanas/".$banner['rutaImagenResponsive']."' alt=''>"); ?>
          <?php Funciones::getHtmlLink($banner['urlEnlaceNoticia'],"<img class='img-responsive visible-md visible-lg ' src='".Yii::$app->homeUrl . "img/campanas/".$banner['rutaImagen']."' alt=''>"); ?>
		  <?php if($existe and $idItem == "bannerArriba" and $banner['idImagenCampana'] == 20): ?>
			  <div class="carousel-caption">
				<h3>Hola <?= $userNombreCompleto ?></h3>
			  </div>
          <?php endif; ?>
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
