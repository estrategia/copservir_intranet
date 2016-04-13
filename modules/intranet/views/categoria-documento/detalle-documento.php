<?php
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = 'Detalle Documento';
?>
<div class="col-md-12">

  <h3><?= $categoriaDocumentoDetalle->objDocumento->titulo  ?></h3>

  <?php
  echo DetailView::widget([
    'model' => $categoriaDocumentoDetalle->objDocumento,
    'attributes' => [
        'titulo',
        'descripcion',
        [
            'label' => 'Descargar',
            'format'=>'raw',
            'value' => Html::a('<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>', [$categoriaDocumentoDetalle->objDocumento->rutaDocumento], []),
        ],
    ],
]);
  ?>

  <hr>
  <!--<div class="grid-body no-border">
    <h3>Historial de cambios</h3>
        <table class="table no-more-tables">
            <thead>
                <tr>
                    <th style="width:9%">Descripcion del cambio</th>
                    <th style="width:22%">fecha del cambio</th>
                    <th style="width:22%">Prioridad</th>
                    <th style="width:6%">Fecha Estimada</th>
                    <th style="width:10%">Progreso</th>
                </tr>
            </thead>
            <tbody id="widget-tareas">

            </tbody>
        </table>
  </div> -->

  <div class="col-md-12">
      <div class="grid simple">
          <div class="grid-title no-border" style="background-color:#367FA9 !important;">
              <h4 style='color:#fff !important;'> Historial  <span class="semi-bold">de cambios</span></h4>
              <div class="tools">
                	<a href="javascript:;" class="collapse"></a>
              </div>
          </div>
          <div class="grid-body no-border">
                  <table class="table no-more-tables">
                      <thead>
                          <tr>
                              <th>Descripción</th>
                              <th>fecha cambio</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php if (count($logDocumento)>0): ?>
                          <?php foreach ($logDocumento as $log): ?>
                            <th><?= $log->descripcion;  ?></th>
                            <th><?= $log->fechaCreacion;  ?></th>

                          <?php endforeach; ?>
                        <?php else: ?>
                            <th>no hay historial para este documento</th>
                            <th></th>
                        <?php endif; ?>
                      </tbody>
                  </table>
          </div>
      </div>
  </div>


</div>
