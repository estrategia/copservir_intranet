<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\trademarketing\models\VariableMedicion;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\VariableMedicion */

$this->title = 'Detalle variable';
//$this->params['breadcrumbs'][] = ['label' => 'Variable Medicions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="space-1"></div>
<div class="space-2"></div>
<div class="container">

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
              'value' =>  $model->calificaUnidadNegocio == 1 ? 'Si' : 'No',
            ],
        ],
    ]) ?>

</div>

<div class="space-1"></div>
<div class="space-2"></div>
