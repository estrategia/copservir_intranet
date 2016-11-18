<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\CriteriosEvaluacionVentas */

$this->title = 'Actualiza un criterio de evaluacion de ventas: ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Criterios'), 'url' => ['/trademarketing/criterios-evaluacion-ventas']];
$this->params['breadcrumbs'][] = "Actualizar";
?>

<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>