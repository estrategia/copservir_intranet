<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\CriteriosEvaluacionVentas */

$this->title = 'Crea criterios de evaluacion de ventas';
// $this->params['breadcrumbs'][] = ['label' => 'Criterios Evaluacion Ventas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
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
