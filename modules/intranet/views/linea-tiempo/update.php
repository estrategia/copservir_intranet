<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\LineaTiempo */

$this->title = 'Update Linea Tiempo: ' . $model->idLineaTiempo;
$this->params['breadcrumbs'][] = ['label' => 'Linea Tiempos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idLineaTiempo, 'url' => ['view', 'id' => $model->idLineaTiempo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linea-tiempo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
