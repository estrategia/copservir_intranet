<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ModuloContenido */

$this->title = 'Actualizar Módulo de Interés';
$this->params['breadcrumbs'][] = ['label' => 'Módulo de Interés', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombreModulo, 'url' => ['detalle', 'id' => $model->idModulo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="modulo-contenido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
