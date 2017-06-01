<?php 
 use yii\helpers\BaseStringHelper;
 use yii\helpers\Url;

?>
    <img class="" src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $model->rutaImagen ?>" >
    <div class="listado-cursos-item-titulo">
      <a href="<?= Url::to(['visualizar-curso', 'id' => $model->idCurso]) ?>">
          <h3 class=""><?= $model->nombreCurso ?></h3>
      </a>
    </div>
