<?php
use yii\helpers\Html;

$this->title = 'Crea una linea de tiempo';
$this->params['breadcrumbs'][] = ['label' => 'Líneas de tiempo', 'url' => ['/intranet/linea-tiempo/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Crear línea de tiempo'];
?>
<div class="linea-tiempo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
