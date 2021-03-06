<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\trademarketing\models\VariableMedicion;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\VariableMedicion */

$this->title = 'Detalle variable';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Variable'), 'url' => ['/trademarketing/variable-medicion']];
$this->params['breadcrumbs'][] = "Detalle";
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idVariable], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['inactivar', 'id' => $model->idVariable], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de inactivar esta variable de medición?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
              'label' => 'Categoria',
              'attribute' => 'categoria.nombre',
            ],
            'nombre',
            'descripcion',
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == VariableMedicion::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
            [
              'attribute' => 'calificaUnidadNegocio',
              'value' =>  $model->calificaUnidadNegocio == VariableMedicion::CALIFICA_UNIDAD ? 'Si' : 'No',
            ],
        ],
    ]) ?>

</div>