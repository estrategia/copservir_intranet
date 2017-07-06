<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\rating\StarRating;

$this->title = 'Mis Cursos Recientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
  <h2>
    Mis cursos recientes
  </h2>
    <a href="<?= Url::to('recomendados') ?>" class="btn btn-default">Recomendados <span class="glyphicon glyphicon-star"></span></a>
    <a href="<?= Url::to('leidos') ?>" class="btn btn-default">Terminados <span class="glyphicon glyphicon-ok-circle"></span></a>
</div>
<br>
<div class="owl-carousel rotor-cursos owl-theme">
  <?php foreach ($cursosBanner as $curso): ?>
    <div class="item">
      <img src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $curso->rutaImagen ?>" alt="">
      <div class="titulo-rotor-cursos"> 
        <a href="<?= Url::to(['visualizar-curso', 'id' => $curso->idCurso]) ?>">
          <h3>
              <?= \yii\helpers\StringHelper::truncateWords($curso->nombreCurso, 5, '...', false); ?>
          </h3>
        </a> 
      </div>
    </div>
  <?php endforeach ?>
</div>
<?php if (empty($cursosBanner)): ?>
  <div class="jumbotron">
    <h1>Sin cursos</h1>
    <p>No tiene cursos asignados, pero puede acceder a todos los cursos usando el siguiente <a href="<?= Url::to('buscador') ?>">link.</a></p>
  </div>
<?php endif ?>

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

<!-- <?php \yii\helpers\VarDumper::dump($cursosBanner,10,true); ?> -->