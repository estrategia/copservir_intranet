<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = 'Crear Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuario Proveedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

