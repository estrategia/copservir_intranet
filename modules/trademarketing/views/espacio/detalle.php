<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\trademarketing\models\Espacio;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\Espacio */

$this->title = 'Detalle espacio';
// $this->params['breadcrumbs'][] = ['label' => 'Espacios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="space-1"></div>
<div class="space-2"></div>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idEspacio], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['inactivar', 'id' => $model->idEspacio], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de inactivar este espacio?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // [
            //   'label' => 'Variable',
            //   'attribute' => 'variable.nombre',
            // ],
            'nombre',
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == Espacio::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
        ],
    ]) ?>

</div>

<div class="space-1"></div>
<div class="space-2"></div>
