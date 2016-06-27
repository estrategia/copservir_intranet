<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\TipoPQRS */

$this->title = Yii::t('app', 'Crear Modulo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Módulos Administrativos'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Crear Módulo')];?>

<div class="tipo-pqrs-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
