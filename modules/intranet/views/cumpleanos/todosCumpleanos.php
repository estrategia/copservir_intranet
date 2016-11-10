<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Cumpleaños';
$this->params['breadcrumbs'][] = $this->title
?>

<h1><?= Html::encode($this->title) ?></h1>
<br>

<div id="cumpleanios">
  <div class="col-md-12">
    <div class="row">
      <?php foreach ($models as $model): ?>
        <div class="col-md-2">
          <div class="grid simple horizontal red">
            <div class="grid-title center-block">
                <h4 style="width: 100%">  <?= $model->nombre  ?> </h4>
            </div>
            <div class="grid-body center-block">
              <div>
              <a href="felicitar-aniversario?id=<?php echo $model->idCumpleanosLaboral?>" class="circle-avatar" style="background-image:url(<?= Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuario->getImagenPerfil() ?>)"></a>
              <!-- <img class='img-circle img-responsive' src="<?= Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuario->getImagenPerfil() ?>" alt="Responsive"> -->
                <p>
                  <?php
                  $fecha_dividida = explode("-", $model->fecha);
                  $mes = \Yii::$app->params['calendario']['meses'][ (int)$fecha_dividida[1]];
                  $dia = $fecha_dividida[2];
                  echo '<div style="font-size: 12px; margin: auto;text-align: center;">'. $dia.' de '.$mes. '</div>';

                  echo "<div class='text-truncate text-truncate-hover' style='width: 100px; font-size: 12px; margin: auto;text-align: center;'>
                          $model->ubicacion
                        </div>";
                  // echo
                  // '<div style="text-align: center;"> '.
                  // Html::a('Felicitar',  ['felicitar-cumpleanos', 'id'=>$model->idCumpleanosPersona], [
                  //   'class' => 'btn btn-primary',
                  // ])
                  // .'</div>';
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<div class="paginacion">
    <?php echo LinkPager::widget([
        'pagination' => $paginas,
    ]); ?>
</div>