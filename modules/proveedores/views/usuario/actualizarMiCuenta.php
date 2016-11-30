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
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_formMiCuenta', [
        'model' => $model,
        'ciudades' => $ciudades,
        'profesiones' => $profesiones,
    ]) ?>
  </div>
</div>
