<?php

use yii\helpers\Html;

$this->title = 'Crea indicadores';
$this->params['breadcrumbs'][] = ['label' => 'Administrar indicadores', 'url' => ['/intranet/indicadores/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Crear  indicador'];
?>
<div class="indicadores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
