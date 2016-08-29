<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\RangoCalificaciones */

$this->title = 'Actualiza un rango de calificaciones';
// $this->params['breadcrumbs'][] = ['label' => 'Rango Calificaciones', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->idRangoCalificacion, 'url' => ['view', 'id' => $model->idRangoCalificacion]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="space-1"></div>
<div class="space-2"></div>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<div class="space-1"></div>
<div class="space-2"></div>
