<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\AreaContenido */

$this->title = 'Actualizar Área de Interés';
$this->params['breadcrumbs'][] = ['label' => 'Área de Interés', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombreArea, 'url' => ['detalle', 'id' => $model->idAreaConocimiento]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="area-contenido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
