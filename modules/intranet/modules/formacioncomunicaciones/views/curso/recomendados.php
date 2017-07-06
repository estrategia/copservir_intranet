<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\rating\StarRating;

$this->title = 'Mis Cursos Recomendados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
  <h2>
    Mis cursos recomendados
  </h2>
    <a href="<?= Url::to('mis-cursos') ?>" class="btn btn-default">Recientes <span class="glyphicon glyphicon-star"></span></a>
    <a href="<?= Url::to('leidos') ?>" class="btn btn-default">Terminados <span class="glyphicon glyphicon-ok-circle"></span></a>
</div>
<br>
<div class="listado-cursos-contenedor">
  <div class="listado-cursos-columna">
    <?php if (!empty($cursosFormacion)): ?>
      <div class="curso-destacado">
        <a href="<?= Url::to(['visualizar-curso', 'id' => $cursosFormacion[0]->idCurso]) ?>">
          <h3 class="titulo-columna-cursos formacion">Formación</h3>
          <img class="" src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $cursosFormacion[0]->rutaImagen ?>" >
          <h2 class="titulo-curso-destacado"> 
          <?= \yii\helpers\StringHelper::truncateWords($cursosFormacion[0]->nombreCurso, 5, '...', false); ?>      
          <?php 
            echo StarRating::widget([
                'name' => 'rating_1',
                'value' =>  $cursosFormacion[0]->promedioCalificacion,
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
          </h2>
        </a>
      </div>
      <div class="listado-cursos">
        <?php foreach ($cursosFormacion as $key => $curso): ?>
          <?php if ($key != 0): ?>
            <a href="<?= Url::to(['visualizar-curso', 'id' => $curso->idCurso]) ?>">
              <div class="listado-cursos-item">
                <img class="" src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $curso->rutaImagen ?>" >
                <div class="listado-cursos-item-titulo">
                  <h3 class="">
                    <?php 
                      echo StarRating::widget([
                          'name' => 'rating_1',
                          'value' =>  $curso->promedioCalificacion,
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
                    <?= \yii\helpers\StringHelper::truncateWords($curso->nombreCurso, 5, '...', false); ?>
                  </h3>
                </div>
              </div>
            </a>
          <?php endif ?>
        <?php endforeach ?>
      </div>
      <a class="ver-mas" href=" <?= Url::to('formacion') ?> ">Ver más</a>
    <?php endif ?>
  </div>
  <div class="listado-cursos-columna">
    <?php if (!empty($cursosComunicacion)): ?>
      <a href="<?= Url::to(['visualizar-curso', 'id' => $cursosComunicacion[0]->idCurso]) ?>">
        <div class="curso-destacado">
          <h3 class="titulo-columna-cursos comunicacion">Comunicación</h3>
          <img class="" src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $cursosComunicacion[0]->rutaImagen ?>" >
          <h2 class="titulo-curso-destacado">
          <?= \yii\helpers\StringHelper::truncateWords($cursosComunicacion[0]->nombreCurso, 5, '...', false); ?>  
          <?php 
              echo StarRating::widget([
                  'name' => 'rating_1',
                  'value' =>  $cursosComunicacion[0]->promedioCalificacion,
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
          </h2>
        </div>
      </a>
      <div class="listado-cursos">
        <?php foreach ($cursosComunicacion as $key => $curso): ?>
          <?php if ($key != 0): ?>
            <a href="<?= Url::to(['visualizar-curso', 'id' => $curso->idCurso]) ?>">
              <div class="listado-cursos-item">
                <img class="" src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $curso->rutaImagen ?>" >
                <div class="listado-cursos-item-titulo">
                  <h3 class="">
                    <?php 
                      echo StarRating::widget([
                          'name' => 'rating_1',
                          'value' =>  $curso->promedioCalificacion,
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
                    <?= \yii\helpers\StringHelper::truncateWords($curso->nombreCurso, 5, '...', false); ?>
                  </h3>
                </div>
              </div>
            </a>
          <?php endif ?>
        <?php endforeach ?>
      </div>
      <a class="ver-mas" href=" <?= Url::to('comunicacion') ?> ">Ver más</a>
    <?php endif ?>
  </div>
</div>
