<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\trademarketing\models\CriteriosEvaluacionVentas;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\CriteriosEvaluacionVentas */

$this->title = 'detalle del criterio de evaluacion de ventas';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Criterios'), 'url' => ['/trademarketing/criterios-evaluacion-ventas']];
$this->params['breadcrumbs'][] = "Detalle";
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idCriterio], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inacivar', ['inactivar', 'id' => $model->idCriterio], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de inactivar este criterio de evaluacion de ventas?',
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
              'value' =>  $model->estado == CriteriosEvaluacionVentas::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
        ],
    ]) ?>

</div>
