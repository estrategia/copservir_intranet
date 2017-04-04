<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CapituloContenido */

$this->title = $model->nombreCapitulo;
$this->params['breadcrumbs'][] = ['label' => 'Capítulo de Interés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capitulo-contenido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idCapitulo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idCapitulo], [
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
            'nombreCapitulo',
            'descripcionCapitulo',
            [
                'label' => 'Estado',
                'value' => $model->estadoCapitulo == 1 ? 'Activo' : 'Inactivo',
            ],
            'fechaCreacion',
            'fechaActualizacion',
        ],
    ]) ?>

</div>
