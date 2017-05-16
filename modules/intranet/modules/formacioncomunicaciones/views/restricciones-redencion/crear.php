<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencion */

$this->title = 'Crear Restricción de Redención';
$this->params['breadcrumbs'][] = ['label' => 'Restricciones de Redención', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restricciones-redencion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
