<?php
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\intranet\models\Documento;

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
            'value' => Html::a('<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>', Yii::getAlias('@web') . Yii::$app->params['documentos']['rutaArchivo'] .$categoriaDocumentoDetalle->objDocumento->rutaDocumento, []),
        ],
        [
          'label' => 'Estado',
          'value' =>  $categoriaDocumentoDetalle->objDocumento->estado == Documento::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
        ],
    ],
]);
  ?>

  <hr>

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
                            <tr>
                              <td><?= $log->descripcion;  ?></td>
                              <td><?= $log->fechaCreacion;  ?></td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td>no hay historial para este documento</td>
                            <td></td>
                          </tr>

                        <?php endif; ?>
                      </tbody>
                  </table>
          </div>
      </div>
  </div>

</div>
