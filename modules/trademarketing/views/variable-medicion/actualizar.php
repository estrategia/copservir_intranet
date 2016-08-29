<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\VariableMedicion */

$this->title = 'actualiza una variable de medicion';
// $this->params['breadcrumbs'][] = ['label' => 'Variable Medicions', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->idVariable, 'url' => ['view', 'id' => $model->idVariable]];
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
