<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Portal */

$this->title = 'Actualizar Portal: ' . $model->nombrePortal;
$this->params['breadcrumbs'][] = ['label' => 'Portales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombrePortal, 'url' => ['view', 'id' => $model->idPortal]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="portal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
