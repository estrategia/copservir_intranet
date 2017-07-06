<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos */

$this->title = 'Actualizar Parametro: ' . $model->idParametroPunto;
$this->params['breadcrumbs'][] = ['label' => 'Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idParametroPunto, 'url' => ['detalle', 'id' => $model->idParametroPunto]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="parametros-puntos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
