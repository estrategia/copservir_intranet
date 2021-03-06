<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\Documento;

$this->title = $model->titulo;
if($flag){
    $this->params['breadcrumbs'][] = ['label' => 'Documentos organizacionales', 'url' => ['/intranet/documento/admin']];
    $this->params['breadcrumbs'][] = ['label' => 'Ver documento'];
}else{
    $this->params['breadcrumbs'][] = ['label' => 'Menú documentos organizacionales', 'url' => ['/intranet/categoria-documento/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Ver documento'];
}
?>

<div class="documento-view col-md-12">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php if ($flag): ?>
    <p>
      <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idDocumento], ['class' => 'btn btn-primary']) ?>
      <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idDocumento], [
        'class' => 'btn btn-danger',
        'data' => [
        'confirm' => 'Estas eguro de eliminar este documento?',
        'method' => 'post',
      ],
      ]) ?>
    </p>
  <?php endif; ?>


  <?php
  echo DetailView::widget([
    'model' => $model,
    'attributes' => [
      'titulo',
      'descripcion',
      [
        'label' => 'Descargar',
        'format'=>'raw',
        'value' => Html::a('<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>', Yii::getAlias('@web') . Yii::$app->params['documentos']['rutaArchivo'] .$model->rutaDocumento, ['target'=>'_blank']),
      ],
      [
        'label' => 'Visualizar Bizagi',
        'format'=>'raw',
        'value' => Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>', Yii::getAlias('@web') . Yii::$app->params['documentos']['rutaArchivo'] .$model->rutaDocumento, ['target'=>'_blank']),
      ],
      [
        'attribute' => 'estado',
        'value' =>  $model->estado == Documento::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
      ],
    ],
  ]);
  ?>

</div>
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
