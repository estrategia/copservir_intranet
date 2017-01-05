<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\Usuario */

$this->title = 'Actualizar mi Cuenta';
$this->params['breadcrumbs'][] = ['label' => 'Mi Cuenta', 'url' => ['mi-cuenta']];
$this->params['breadcrumbs'][] = 'Actualizar mi cuenta';
?>
<div class="container">
  <div class="row">
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <strong>
              <?= Yii::$app->session->getFlash('error') ?>
            </strong>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <strong>
              <?= Yii::$app->session->getFlash('success') ?>
            </strong>
        </div>
    <?php endif; ?>
    
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Recuerde actualizar su <strong>información personal, información de contacto y confirma que acepta la política de tratamiento de datos</strong> para acceder a los servicios del Portal Colaborativo de Copservir Ltda.<p>
    <?= $this->render('_formMiCuenta', [
        'model' => $model,
        'ciudades' => $ciudades,
        'profesiones' => $profesiones,
    ]) ?>
  </div>
</div>
