<?php
use yii\helpers\Html;
?>

<section id="carousel-cumpleanos">
  <div class="internal col-md-12">
    <div id="<?= 'owl-'.$flag ?>" class="owl-carousel">

      <?php foreach ($models as $model): ?>

        <div class="item orange center-block " style="text-align: center;">
          <img  class='img-circle img-responsive' src="<?= Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuario->imagenPerfil ?>"
            alt="Responsive" style="width: 50%;margin-left: auto; margin-right: auto;">
          <p>
            <?php
            $fecha_dividida = explode("-", $model->fecha);
            $mes = \Yii::$app->params['calendario']['meses'][ (int)$fecha_dividida[1]];
            $dia = $fecha_dividida[2];
            if ($flag=='Cumpleaños') {
              echo '<p>';
              echo
              Html::a('<h5>'.$model->nombre.'</h5>',  ['felicitar-cumpleanos', 'id'=>$model->idCumpleanosPersona], [
              ]);
              echo '</p>';
              echo "Cumple el ".$dia.' de '.$mes;
            }else{
              echo '<p>';
              echo
              Html::a('<h5>'.$model->nombre.'</h5>',  ['felicitar-aniversario','id'=>$model->idCumpleanosLaboral], [

              ]);
              echo '</p>';
              echo "Aniversario el ".$dia.' de '.$mes;
            }
            ?>
          </p>
        </div>

      <?php endforeach; ?>
    </div>
  </div>
</section>
