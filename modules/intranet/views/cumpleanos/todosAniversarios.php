<?php

use yii\helpers\Html;

$this->title = 'Aniversarios';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="col-md-12">
  <?php foreach ($models as $model): ?>

    <div class="col-md-3 center-block">
      <div class="grid simple horizontal red">
        <div class="grid-title  center-block">
          <h4>  <?= $model->nombre  ?> </h4>
          <!--<div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>-->
        </div>
        <div class="grid-body center-block">
          <div>
            <img class='img-circle img-responsive' src="<?= Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuario->imagenPerfil ?>" alt="Responsive">
            <br>
            <p>
              <?php
              $fecha_dividida = explode("-", $model->fecha);
              $mes = \Yii::$app->params['calendario']['meses'][ (int)$fecha_dividida[1]];
              $dia = $fecha_dividida[2];
              echo "Aniversario el ".$dia.' de '.$mes;
              ?>
            </p>
          </div>
        </div>
      </div>

    </div>

  <?php endforeach; ?>
</div>
