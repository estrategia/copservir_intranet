<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = 'Actualizar Usuario: ' . $model->nombre . ' ' . $model->primerApellido;
$this->params['breadcrumbs'][] = ['label' => ' Gestion de Usuarios', 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre . ' ' . $model->primerApellido, 'url' => ['ver', 'id' => $model->numeroDocumento]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>

<div class="container">
  <h3><?= Html::encode($this->title) ?></h3>
  <?= $this->render('_form', [
      'model' => $model,
      'terceros' => $terceros,
      'ciudades' => $ciudades,
  ]) ?>
</div>
     
