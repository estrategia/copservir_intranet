<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\AreaContenido */

$this->title = $model->nombreArea;
$this->params['breadcrumbs'][] = ['label' => 'Áreas de Interés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-contenido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idAreaConocimiento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idAreaConocimiento], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que quiere eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombreArea',
            'descripcionArea',
            [
               'label' => 'estadoArea',
               'value' => $model->estadoArea == 1 ? 'Activo' : 'Inactivo',
            ],
            'fechaCreacion',
            'fechaActualizacion',
        ],
    ]) ?>

</div>
