<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\VariableMedicion */

$this->title = 'Crea una variable de medicion';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Variable'), 'url' => ['/trademarketing/variable-medicion']];
$this->params['breadcrumbs'][] = "Crear";
?>

<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

