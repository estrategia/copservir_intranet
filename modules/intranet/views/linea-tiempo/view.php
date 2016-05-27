<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\LineaTiempo */

$this->title = $model->idLineaTiempo;
$this->params['breadcrumbs'][] = ['label' => 'Linea Tiempos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linea-tiempo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idLineaTiempo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idLineaTiempo], [
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
            'idLineaTiempo',
            'nombreLineaTiempo',
            'estado',
            'autorizacionAutomatica',
            'tipo',
            'solicitarGrupoObjetivo',
            'orden',
            'fechaInicio',
            'fechaFin',
            'color',
            'icono',
            'descripcion',
        ],
    ]) ?>

</div>
