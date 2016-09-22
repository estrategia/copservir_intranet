<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\RangoCalificaciones */

$this->title = 'Actualiza un rango de calificaciones';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Rango calificaciones'), 'url' => ['/trademarketing/rango-calificaciones']];
$this->params['breadcrumbs'][] = "Actualizar";
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>