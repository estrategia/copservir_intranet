<?php 
use yii\helpers\Url;
use kartik\rating\StarRating;

?>
<br>
<div class="col-md-12">
  <h2>Reseñas del contenido</h2>
  <div class="calificacion-contenido">
    <div class="calificacion-imagen-usuario">
      <a href=" <?= Url::to(['/intranet/usuario/ver', 'documento' => $model->usuarioPublicador->numeroDocumento]) ?> ">
        <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $model->usuarioPublicador->getImagenPerfil() ?> alt="" data-src="" data-src-retina="" width="60" height="60">
      </a>
    </div>
    <div class="calificacion-body">
      <p class="calificacion-comentario">
        <?= $model->comentario ?>
      </p>
      <?php 
        echo StarRating::widget([
            'name' => 'rating_1',
            'value' => $model->calificacion,
            'pluginOptions' => [
              'displayOnly' => true,
              'showClear'=> false,
              'showCaption' => false,
              'filledStar' => '<i class="glyphicon glyphicon-star"></i>',
              'emptyStar' => '<i class="glyphicon glyphicon-star-empty"></i>',
              'size' => 'xs'
            ]
        ]);
      ?>
      <hr>
    </div>
  </div>
</div>