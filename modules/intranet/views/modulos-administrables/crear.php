<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\TipoPQRS */

$this->title = Yii::t('app', 'Crear Modulo');

echo Breadcrumbs::widget([
    'itemTemplate' => "<li>{link}</li>\n",
    'homeLink' => [
        'label' => 'Inicio',
        'url' => ['/intranet/'],
    ],
    'links' => [
        [
            'label' => 'Modulos Administrativos',
            'url' => ['admin'],
        ],
        'Crear Módulo',
    ],
]);?>

<div class="tipo-pqrs-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
