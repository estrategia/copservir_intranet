<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = 'Actualizar Usuario: ' . $model->nombre . ' ' . $model->primerApellido;
$this->params['breadcrumbs'][] = ['label' => 'Usuario', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre . ' ' . $model->primerApellido, 'url' => ['view', 'id' => $model->numeroDocumento]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="container">
  <div class="row">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'terceros' => $terceros,
        'unidadesNegocio' => $unidadesNegocio,
        'ciudades' => $ciudades,
    ]) ?>
  </div>
</div>
