<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */

$this->title = 'Update Ofertas Laborales: ' . ' ' . $model->idOfertaLaboral;
$this->params['breadcrumbs'][] = ['label' => 'Ofertas Laborales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idOfertaLaboral, 'url' => ['view', 'id' => $model->idOfertaLaboral]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ofertas-laborales-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
