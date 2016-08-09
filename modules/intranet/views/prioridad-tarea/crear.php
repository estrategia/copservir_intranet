<?php
use yii\helpers\Html;

$this->title = 'Crear Prioridad Tarea';
$this->params['breadcrumbs'][] = ['label' => 'Prioridad Tareas', 'url' => ['/intranet/prioridad-tarea/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prioridad-tarea-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
