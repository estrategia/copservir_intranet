<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\Espacio */

$this->title = 'Crea un Espacio';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Espacios'), 'url' => ['/trademarketing/espacio']];
$this->params['breadcrumbs'][] = "Crear";
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
