<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\MenuPortales;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\MenuPortales */

$this->title = "Detalle menu portal";
$this->params['breadcrumbs'][] = ['label' => 'Menú portales', 'url' => ['/intranet/menu-portales/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Ver menú'];
?>
<div class="menu-portales-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idMenuPortales], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idMenuPortales], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar este menu del portal?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            [
              'attribute' => 'icono',
              'format'=>'raw',
              'value' => '<i class="'.$model->icono.'"></i>'
            ],
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == MenuPortales::APROBADO ? 'Activo' : 'Inactivo',
            ],
            [
              'attribute' => 'tipo',
              'value' => ($model->tipo === MenuPortales::ENLACE_INTERNO) ? 'Enlace interno' :
                'Enlace externo',
            ],
            'urlMenu:url',
        ],
    ]) ?>

</div>
