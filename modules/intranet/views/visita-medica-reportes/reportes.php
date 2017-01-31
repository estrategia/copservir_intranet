<?php
  use yii\helpers\Html;
  use kartik\select2\Select2;
  use app\assets\VisitaMedicaReportesAsset;
  VisitaMedicaReportesAsset::register($this);
  $baseUrl = Yii::$app->getUrlManager()->getBaseUrl();

  $this->title = 'Reportes';
  // $this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['/proveedores/visitamedica/reportes']];
  $this->params['breadcrumbs'][] = ['label' => 'Reportes'];

?>
<h1>Reportes Visitamedica</h1>
<?php if (Yii::$app->session->hasFlash('error')): ?>
  <div class="alert alert-info">
    <?= Yii::$app->session->getFlash('error'); ?>
  </div>
<?php endif ?>
<div class="row">
  <div class="col-md-12">
    <?php echo Select2::widget([
        'id' => 'selectorNitLaboratorio',
        'name' => 'nitLaboratorio',
        'value' => '',
        'data' => $tercerosSelect,
        'options' => ['multiple' => false, 'placeholder' => 'Selecciona un proveedor']
    ]); ?>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-6">
    <a class="btn btn-success btn-block hidden" id="boton-reportes-consultas" href=" <?php echo ($baseUrl . '/intranet/visitamedica/reportes/producto/hoy'); ?> ">Registros de consultas</a>
  </div>

  <div class="col-md-6">
    <a class="btn btn-success btn-block hidden" id="boton-reportes-acceso" href=" <?php echo ($baseUrl . '/intranet/visitamedica/reportes/acceso/hoy'); ?> ">Registros de acceso</a>
  </div>
</div>
