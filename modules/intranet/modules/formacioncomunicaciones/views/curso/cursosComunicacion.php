<?php 
use yii\helpers\Url; 

$this->title = 'Cursos de Comunicación';
$this->params['breadcrumbs'][] = ['label' => 'Mis Cursos', 'url' => Url::to('mis-cursos')];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (empty($cursosComunicacion)): ?>
  <div class="jumbotron">
    <h1>Sin cursos</h1>
    <p>No tiene cursos asignados, pero puede acceder a todos los cursos usando el siguiente <a href="<?= Url::to('buscador') ?>">link.</a></p>
  </div>
<?php else: ?>
<h3 class="titulo-columna-cursos comunicacion">Comunicación</h3>
<div class="listado-cursos-contenedor">
    <div class="listado-cursos-todos">
        <?php foreach ($cursosComunicacion as $key => $curso): ?>
            <div class="listado-cursos-item">
              <img class="" src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $curso->rutaImagen ?>" >
              <div class="listado-cursos-item-titulo">
                <h3 class=""><?= $curso->nombreCurso ?></h3>
              </div>
            </div>
        <?php endforeach ?>
      </div>
</div>
<?php endif ?>