<?php

use yii\helpers\Html;

$this->title = 'Actualizar indicador';
$this->params['breadcrumbs'][] = ['label' => 'Administrar indicadores', 'url' => ['/intranet/indicadores/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Actualizar indicador'];
?>
<div class="indicadores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
