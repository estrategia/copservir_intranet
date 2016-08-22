<?php

use yii\helpers\Html;

$this->title = 'Aniversarios';
$this->params['breadcrumbs'][] = $this->title
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="col-md-12">
  <?php foreach ($models as $model): ?>

    <div class="col-md-3 center-block">
      <div class="grid simple horizontal red">
        <div class="grid-title  center-block">
          <h4>  <?= $model->nombre  ?> </h4>
        </div>
        <div class="grid-body center-block">
          <div>
            <img class='img-circle img-responsive' src="<?= Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuario->getImagenPerfil() ?>" alt="Responsive">
            <br>
            <p>
              <?php
              $fecha_dividida = explode("-", $model->fecha);
              $mes = \Yii::$app->params['calendario']['meses'][ (int)$fecha_dividida[1]];
              $dia = $fecha_dividida[2];
              echo '<div style="font-size: 12px; margin: auto;text-align: center;">'. $dia.' de '.$mes. '</div>';
              $datetime1 = date_create($model->fecha);
              $datetime2 = date_create($model->fechaIngreso);
              $interval = date_diff($datetime1, $datetime2);
              echo "<div style='font-size: 12px; margin: auto;text-align: center;'>Cumple: ".$interval->format('%y')." años</div>";
              echo
              '<div style="text-align: center;">'.
              Html::a('Felicitar',  ['felicitar-aniversario','id'=>$model->idCumpleanosLaboral], [
                'class' => 'btn btn-primary',
              ])
              . '</div>'
              ;
              ?>
            </p>
          </div>
        </div>
      </div>

    </div>

  <?php endforeach; ?>
</div>
