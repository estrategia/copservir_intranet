<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = 'Crear Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Gestion de Usuarios', 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
  <div class="row">
    <h1><?= Html::encode($this->title) ?> <small><?= Yii::$app->user->identity->objUsuarioProveedor->nombreLaboratorio ?></small></h1>
    <?= $this->render('_form', [
      'model' => $model,
      'terceros' => $terceros,
      'ciudades' => $ciudades,
    ]) ?>
  </div>
</div>

