<?php 
 use yii\helpers\BaseStringHelper;
 use yii\helpers\Url;

?>
<div class="buscador-fila">
    
  <div class="buscador-fila-seccion-izquierda">
    <h1 class="buscador-titulo">
      <a href="<?=  Url::toRoute(['curso/visualizar-curso', 'id' => $model->idCurso]); ?>" >
        <?= $model->nombreCurso; ?>
      </a>
    </h1>
    <p class="buscador-descripcion-contenido">
      <?= BaseStringHelper::truncate($model->presentacionCurso, 50, '...', null, false);?>
    </p>
  </div>
</div>