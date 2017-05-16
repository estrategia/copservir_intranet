<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Contenido */

$this->title = $model->objPremio->nombrePremio;
$this->params['breadcrumbs'][] = ['label' => 'Mis redenciones', 'url' => ['mis-redenciones']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contenido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cantidad',
            'puntosRedimir',
            'fechaCreacion',
            [
                'attribute' => 'estado',
                'format' => 'raw',
                'value' => $model->getNombreEstado()
            ]
        ],
    ]) ?>

</div>
