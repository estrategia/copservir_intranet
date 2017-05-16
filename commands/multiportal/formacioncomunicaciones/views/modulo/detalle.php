<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ModuloContenido */

$this->title = $model->nombreModulo;
$this->params['breadcrumbs'][] = ['label' => 'Módulo de Interés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modulo-contenido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idModulo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idModulo], [
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
            'nombreModulo',
            'descripcionModulo',
            [
                'label' => 'Estado',
                'value' => $model->estadoModulo == 1 ? 'Activo' : 'Inactivo',
            ],
            'fechaCreacion',
            'fechaActualizacion',
        ],
    ]) ?>

</div>
