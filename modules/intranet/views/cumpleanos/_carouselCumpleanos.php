<?php
  use yii\helpers\Html;
?>

<div class="grid simple">
  <div class="grid-title no-border" style='background-color:#0AA699 !important'>
      <h4 style='color:#fff !important;'><?= $flag  ?><span class="semi-bold"></span></h4>
      <div class="tools">
        <?php if ($flag=='Cumpleaños'): ?>
          <?=
              Html::a('Ver todos',  ['todos-cumpleanos'], [
                  'class' => 'btn btn-primary',
              ]);
           ?>
        <?php else: ?>
          <?=
              Html::a('Ver todos',  ['todos-aniversarios'], [
                  'class' => 'btn btn-primary',
              ]);
           ?>
        <?php endif ?>
        <a href="javascript:;" data-role="quitar-elemento" data-elemento="" class="remove"></a>
      </div>
  </div>

  <div class="spacing-bottom"></div>
  <div class="grid-body no-border">

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
                  }else{
                    echo "Aniversario el ".$dia.' de '.$mes;
                  }

                 ?>
              </p>
            </div>

          <?php endforeach; ?>
        </div>
      </div>
    </section>

  </div>
</div>
