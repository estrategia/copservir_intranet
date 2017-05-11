<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\Usuario */

$this->title = 'Actualizar Usuario: ' . $model->numeroDocumento;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => $model->numeroDocumento, 'url' => ['ver', 'id' => $model->numeroDocumento]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">
          <div class="panel-title">
            <h3>
              <?= Html::encode($this->title) ?>          
            </h3>
          </div>
        </div>  
        <div class="panel-body">
          <?= $this->render('_form', [
              'model' => $model,
          ]) ?>
        </div>
    </div>
  </div>
</div>
