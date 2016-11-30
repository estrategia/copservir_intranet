<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = 'Actualizar Usuario: ' . $model->nombre . ' ' . $model->primerApellido;
$this->params['breadcrumbs'][] = ['label' => ' Gestion de Usuarios', 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre . ' ' . $model->primerApellido, 'url' => ['ver', 'id' => $model->numeroDocumento]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panel-title">
          <h3><?= Html::encode($this->title) ?></h3>
        </div>
      </div>
      <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'terceros' => $terceros,
            'unidadesNegocio' => $unidadesNegocio,
            'ciudades' => $ciudades,
        ]) ?>
      </div>
    </div>
  </div>
</div>
