<?php if(!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_INDICADORES."_".$indicador->idIndicador,Yii::$app->user->identity->getOcultosDashboard())): ?>

  <div id='indicador_<?= $indicador->idIndicador ?>'>
    <div class="tiles <?= $indicador->colorFondo ?>    m-b-10">
      <div class="tiles-body">
        <div class="controller">
          <a href="javascript:;" class="reload"></a>
          <a href="javascript:;" data-role="quitar-elemento" data-elemento="<?=\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_INDICADORES?>_<?= $indicador->idIndicador ?>" class="remove"></a>
        </div>
        <h4 class="text-black no-margin semi-bold"><?= $indicador->descripcion ?></h4>
        <h2 class="text-white bold "><?= $indicador->valor ?></h2>
        <div class="description">
          <?= $indicador->textoComplementario ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
