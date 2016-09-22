<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\trademarketing\models\RangoCalificaciones;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\RangoCalificaciones */

$this->title = 'Detalle rango de calificaciones';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Rango calificaciones'), 'url' => ['/trademarketing/rango-calificaciones']];
$this->params['breadcrumbs'][] = "Detalle";
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idRangoCalificacion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['inactivar', 'id' => $model->idRangoCalificacion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de inactivar este rango de calificacion?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'valor',
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == RangoCalificaciones::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
        ],
    ]) ?>

</div>
