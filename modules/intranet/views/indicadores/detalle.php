<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\Indicadores;

$this->title = 'Ver indicador';
$this->params['breadcrumbs'][] = ['label' => 'Administrar indicadores', 'url' => ['/intranet/indicadores/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Ver indicador'];
?>
<div class="indicadores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idIndicador], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idIndicador], [
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
