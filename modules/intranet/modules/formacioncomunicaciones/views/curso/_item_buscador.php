<?php 
 use yii\helpers\BaseStringHelper;
 use yii\helpers\Url;
use kartik\rating\StarRating;

?>
    <img class="" src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $model->rutaImagen ?>" >
    <div class="listado-cursos-item-titulo">
      <a href="<?= Url::to(['visualizar-curso', 'id' => $model->idCurso]) ?>">
          <h3 class="">
           <?php 
              echo StarRating::widget([
                  'name' => 'rating_1',
                  'value' =>  $model->promedioCalificacion,
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
          <?= \yii\helpers\StringHelper::truncateWords($model->nombreCurso, 5, '...', false); ?>
              
          </h3>
      </a>
    </div>
