<?php 
  use yii\helpers\Url;
?>
<input type="button" class="btn" data-role="toogle-collapsible" data-valor="0" value="Colapsar"></input>
<div class="list-group list-group-root well" id="contenido-curso" data-curso-id="<?= $model->idCurso ?>">
  <?php if (empty($model->modulos)): ?>
    <h3>Sin contenido</h3>
  <?php endif ?>
  <?php foreach ($model->modulosActivos as $key => $modulo): ?>
    <div class="list-group-item" data-toggle="collapse" data-target="<?= '#modulo'. $modulo->idModulo ?>" >
      <i class="glyphicon glyphicon-chevron-right"></i>
      <span class="collapse-titulo">
        <?= $modulo->nombreModulo ?>
      </span>
    </div>
    <div id="<?= 'modulo'. $modulo->idModulo ?>" class="list-group collapse in">
      <?php foreach ($modulo->capitulosActivos as $key => $capitulo): ?>
        <div class="list-group-item " data-toggle="collapse" data-target="<?= '#capitulo'. $capitulo->idCapitulo ?>">
          <i class="glyphicon glyphicon-chevron-right"></i>
          <span class="collapse-titulo">
            <?= $capitulo->nombreCapitulo ?>
          </span>
        </div>
        <div id="<?= 'capitulo'. $capitulo->idCapitulo ?>" class="list-group collapse in">
          <?php foreach ($capitulo->contenidosActivos as $key => $contenido): ?>
            <?php $leido = is_null($contenido->contenidoLeidoUsuario) ? false : true ?>
            <div class="list-group-item <?php if ($leido) echo 'contenido-leido' ?>" style="padding-left: 45px;">
              <span class="collapse-titulo">
                <a href=" <?php echo Url::to(['contenido/visualizar-contenido', 'id' => $contenido->idContenido]) ?> ">
                  
                - <?= $contenido->tituloContenido ?>
                <?php if ($leido): ?>
                  <span class="etiqueta-contenido-leido">
                    <span class="glyphicon glyphicon-ok"></span>
                  </span>
                <?php endif ?>
                </a>
              </span>
            </div>
          <?php endforeach ?>
        </div>
      <?php endforeach ?>
    </div>
  <?php endforeach ?>
</div>