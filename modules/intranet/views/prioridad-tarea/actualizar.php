<?php
use yii\helpers\Html;

$this->title = 'Actualiza Prioridad Tarea: ';
$this->params['breadcrumbs'][] = ['label' => 'Prioridad Tareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPrioridadTarea, 'url' => ['view', 'id' => $model->idPrioridadTarea]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="prioridad-tarea-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
