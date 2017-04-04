<?php 
  use yii\helpers\Html;
?>
<div class="list-group list-group-root well" id="contenido-curso" data-curso-id="<?= $model->idCurso ?>">
  <?php if (empty($model->modulos)): ?>
    <h3>Sin contenido</h3>
  <?php endif ?>
  <?php foreach ($model->modulos as $key => $modulo): ?>
    <div class="list-group-item" data-toggle="collapse" data-target="<?= '#modulo'. $modulo->idModulo ?>" >
      <i class="glyphicon glyphicon-chevron-right"></i>
      <span class="collapse-titulo">
        <?= $modulo->nombreModulo ?>
      </span>
    </div>
    <div id="<?= 'modulo'. $modulo->idModulo ?>" class="list-group collapse">
      <?php foreach ($modulo->capitulos as $key => $capitulo): ?>
        <div class="list-group-item" data-toggle="collapse" data-target="<?= '#capitulo'. $capitulo->idCapitulo ?>">
          <i class="glyphicon glyphicon-chevron-right"></i>
          <span class="collapse-titulo">
            <?= $capitulo->nombreCapitulo ?>
          </span>
        </div>
        <div id="<?= 'capitulo'. $capitulo->idCapitulo ?>" class="list-group collapse">
          <?php foreach ($capitulo->contenidos as $key => $contenido): ?>
            <div class="list-group-item" style="padding-left: 45px;">
              <span class="collapse-titulo">
                - <?= $contenido->tituloContenido ?>
              </span>
              <?= Html::a('&bull;  Ver contenido', ['contenido/visualizar-contenido', 'id' => $contenido->idContenido], ['class' => 'collapse-accion']) ?>
            </div>
          <?php endforeach ?>
        </div>
      <?php endforeach ?>
    </div>
  <?php endforeach ?>
</div>