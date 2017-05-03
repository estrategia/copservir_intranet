<?php
  use yii\helpers\Html;
  $baseUrl = Yii::$app->getUrlManager()->getBaseUrl();

  $this->title = 'Reportes';
  // $this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['/proveedores/visitamedica/reportes']];
  $this->params['breadcrumbs'][] = ['label' => 'Reportes'];

?>

<a class="btn btn-default" href=" <?php echo ($baseUrl . '/proveedores/visitamedica/reportes/producto/hoy'); ?> ">Registros de consultas</a>
<a class="btn btn-default" href=" <?php echo ($baseUrl . '/proveedores/visitamedica/reportes/acceso/hoy'); ?> ">Registros de acceso</a>
