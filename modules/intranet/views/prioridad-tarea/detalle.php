<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\PrioridadTarea;

$this->title = 'Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Prioridad Tareas', 'url' => ['/intranet/prioridad-tarea/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prioridad-tarea-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idPrioridadTarea], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inacivar', ['eliminar', 'id' => $model->idPrioridadTarea], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de inactivar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == PrioridadTarea::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
        ],
    ]) ?>

</div>
