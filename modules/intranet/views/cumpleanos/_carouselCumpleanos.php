<?php
use yii\helpers\Html;
?>

<section id="carousel-cumpleanos">
  <div class="internal col-md-12">
    <div id="<?= 'owl-'.$flag ?>" class="owl-carousel">

      <?php foreach ($models as $model): ?>

        <div class="item orange center-block ">
          <img  class='img-circle img-responsive' src="<?= Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuario->imagenPerfil ?>" alt="Responsive" style="width: 50%;">
          <h5>
            <?= $model->nombre  ?>
          </h5>
          <p>
            <?php
            $fecha_dividida = explode("-", $model->fecha);
            $mes = \Yii::$app->params['calendario']['meses'][ (int)$fecha_dividida[1]];
            $dia = $fecha_dividida[2];
            if ($flag=='Cumpleaños') {
              echo "Cumple el ".$dia.' de '.$mes;
              echo '<p>';
              echo
              Html::a('Felicitar',  ['felicitar-cumpleanos', 'id'=>$model->idCumpleanosPersona], [
                'class' => 'btn btn-primary',
              ]);
              echo '</p>';
            }else{
              echo "Aniversario el ".$dia.' de '.$mes;
              echo '<p>';
              echo
              Html::a('Felicitar',  ['felicitar-aniversario','id'=>$model->idCumpleanosLaboral], [
                'class' => 'btn btn-primary',
              ]);
              echo '</p>';
            }
            ?>
          </p>
        </div>

      <?php endforeach; ?>
    </div>
  </div>
</section>
