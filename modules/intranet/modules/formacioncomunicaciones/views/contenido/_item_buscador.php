<?php 
 use yii\helpers\BaseStringHelper;
 use yii\helpers\Url;

?>
<div class="buscador-fila">
    
  <div class="buscador-fila-seccion-izquierda">
    <h1 class="buscador-titulo">
      <a href="<?=  Url::toRoute(['contenido/visualizar-contenido', 'id' => $model->idContenido]); ?>" >
        <?= $model->tituloContenido; ?>
      </a>
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