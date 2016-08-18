<?php
use yii\helpers\Html;
?>

<section id="carousel-cumpleanos">
  <div class="internal col-md-12">
    <div id="<?= 'owl-'.$flag ?>" class="owl-carousel">
      <?php foreach ($models as $model): ?>
        <div class="item orange center-block " style="text-align: center;">
          <img class='img-circle img-responsive' src="<?= Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuario->getImagenPerfil() ?>" alt="<?=$model->nombre?>" style="width: 30%; margin-left: auto; margin-right: auto;">
            <?php
            $fecha_dividida = explode("-", $model->fecha);
            $mes = \Yii::$app->params['calendario']['meses'][ (int)$fecha_dividida[1]];
            $dia = $fecha_dividida[2];
            if ($flag=='Cumpleaños') {
              echo Html::a("<div class='text-truncate text-truncate-hover' style='width: 100px; font-size: 12px; margin: auto;'>$model->nombre</div>",  ['felicitar-cumpleanos', 'id'=>$model->idCumpleanosPersona], []);
              echo "<div class='text-truncate text-truncate-hover'
              style='width: 100px; font-size: 12px; margin: auto;'>$model->ubicacion</div>";
            }else{
              echo Html::a("<div class='text-truncate text-truncate-hover' style='width: 100px; font-size: 12px; margin: auto;'>$model->nombre</div>",  ['felicitar-aniversario','id'=>$model->idCumpleanosLaboral], []);
              $datetime1 = date_create($model->fecha);
              $datetime2 = date_create($model->fechaIngreso);
              $interval = date_diff($datetime1, $datetime2);
              echo "<div>Cumple: ".$interval->format('%y')." años</div>";
            }
            ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
