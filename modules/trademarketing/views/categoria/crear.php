<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\Categoria */

$this->title = 'Crear una categoria';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Categorías'), 'url' => ['/trademarketing/categoria']];
$this->params['breadcrumbs'][] = "Crear";
?>

<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>