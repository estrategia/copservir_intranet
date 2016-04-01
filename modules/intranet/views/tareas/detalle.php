<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Tareas */

$this->title = $model->idTarea;
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tareas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['actualizar', 'id' => $model->idTarea], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['eliminar', 'id' => $model->idTarea], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idTarea',
            'titulo',
            'descripcion:ntext',
            'numeroDocumento',
            'fechaRegistro',
            'estadoTarea',
            'fechaEstimada',
            'idPrioridad',
        ],
    ]) ?>

</div>