<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Tareas */

$this->title = 'Tarea: '.$model->titulo;
//$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tareas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idTarea], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idTarea], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar esta tarea?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'titulo',
            'descripcion:ntext',
            'fechaRegistro',
            'estadoTarea',
            'fechaEstimada',
            //'idPrioridad',
            /*[
              'attribute'=>'idPrioridad',
              'value'=>$model->author->name,
              'widgetOptions'=>[
                'data'=>ArrayHelper::map($prioridadTarea, 'idPrioridadTarea', 'nombre'),
              ]
            ]*/
        ],
    ]) ?>

</div>
