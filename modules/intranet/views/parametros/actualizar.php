<?php
use yii\helpers\Html;

$this->title = 'Actualiza el parametro: ' . $model->idParametro;
$this->params['breadcrumbs'][] = ['label' => 'Parametros de aplicación', 'url'=>['/intranet/parametros/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Actualizar parámetro'];
?>
<div class="parametros-update">


    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <p>
      <?= Html::encode($model->descripcion); ?>
    </p>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
