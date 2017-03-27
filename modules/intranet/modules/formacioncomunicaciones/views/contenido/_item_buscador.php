<?php 
 use yii\helpers\BaseStringHelper;

?>
<div class="buscador-fila">
  <div class="buscador-fila-seccion-izquierda">
    <h1 class="buscador-titulo">
      <?= $model->tituloContenido; ?>
    </h1>
    <p class="buscador-descripcion-contenido">
      <?= BaseStringHelper::truncate($model->descripcionContenido, 50, '...', null, false);?>
    </p>
  </div>
  <div class="buscador-fila-seccion-derecha">
    <p class="buscador-capitulo">
      <?= $model->capitulo->nombreCapitulo; ?>
    </p>
    <p class="buscador-area">
      <?= $model->areaConocimiento->nombreArea; ?>
    </p>
    <p class="buscador-modulo">
      <?= $model->modulo->nombreModulo; ?>
    </p>
    <p class="buscador-tipo-contenido">
      <?= $model->tipoContenido->nombreTipoContenido; ?>
    </p>
  </div>
  <hr>
</div>