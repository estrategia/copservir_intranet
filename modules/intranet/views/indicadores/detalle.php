<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\Indicadores;

$this->title = 'Detalle indicador';

?>
<div class="indicadores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idIndicador], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['delete', 'id' => $model->idIndicador], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de desactivar este indicador ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'descripcion',
            'valor',
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == Indicadores::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
            [
              'attribute' => 'colorFondo',
              'format'=>'raw',
              'value' => '<span class="badge" style="background-color: '.$model->colorFondo.'">&nbsp;</span>'

            ],
            'textoComplementario',
        ],
    ]) ?>

</div>
