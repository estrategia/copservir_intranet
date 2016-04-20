<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\ContenidoEmergente;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\ContenidoEmergente */

$this->title = 'Detalle del Contenido Emergente';
//$this->params['breadcrumbs'][] = ['label' => 'Contenido Emergentes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contenido-emergente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idContenidoEmergente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idContenidoEmergente], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar este contenido emergente?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'contenido:ntext',
            'fechaInicio',
            'fechaFin',
            [
              'label' => 'Estado',
              'value' =>  $model->estado == ContenidoEmergente::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
        ],
    ]) ?>

</div>
