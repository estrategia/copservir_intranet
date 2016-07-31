<?php
use yii\helpers\Html;

$this->title = 'Actualiza una linea de tiempo';
$this->params['breadcrumbs'][] = ['label' => 'Líneas de tiempo', 'url' => ['/intranet/linea-tiempo/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Actualizar línea de tiempo'];
?>
<div class="linea-tiempo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
