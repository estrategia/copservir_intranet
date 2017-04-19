<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenido */

$this->title = $model->nombreTipoContenido;
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Contenidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-contenido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idTipoContenido], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombreTipoContenido',
            [
                'label' => 'Estado',
                'value' => $model->estadoTipoContenido == 1 ? 'Activo' : 'Inactivo',
            ],
            'fechaCreacion',
            'fechaActualizacion',
        ],
    ]) ?>

</div>
