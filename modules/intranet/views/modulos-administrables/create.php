<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\TipoPQRS */

$this->title = Yii::t('app', 'Crear Modulo');

echo Breadcrumbs::widget([
    'itemTemplate' => "<li>{link}</li>\n", // template for all links
    'links' => [
        [
            'label' => 'Modulos Administrativos',
            'url' => ['index'],
        ],
        'Crear Módulo',
    ],
]);?>

<div class="tipo-pqrs-create">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
