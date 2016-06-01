<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TipoPQRS */

$this->title = Yii::t('app', 'Crear Modulo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Módulos Contenidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-pqrs-create">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
