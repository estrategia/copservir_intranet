<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Puntos';
$this->params['breadcrumbs'][] = ['label' => 'Parametros - Puntos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProviderPuntos,
    'filterModel' => $searchModelPuntos,
    'columns' => [

        'idPunto',
        // 'numeroDocumento',
        'descripcionPunto',
        'valorPuntos',
        [
                'attribute' => '',
                'label' => 'Nombres',
                'value' => 'objUsuarioIntranet.nombres',
                'filter' => Html::activeInput('text', $searchModelPuntos, 'nombres', ['class' => 'form-control']),
            ],
            [
                'attribute' => '',
                'label' => 'Primer Apellido',
                'value' => 'objUsuarioIntranet.primerApellido',
                'filter' => Html::activeInput('text', $searchModelPuntos, 'primerApellido', ['class' => 'form-control']),
            ],
            [
                'attribute' => '',
                'label' => 'Segundo Apellido',
                'value' => 'objUsuarioIntranet.segundoApellido',
                'filter' => Html::activeInput('text', $searchModelPuntos, 'segundoApellido', ['class' => 'form-control']),
            ],
        [
            'attribute' => 'tipoParametro',
            'value'  => function ($model)
            {
                if ($model->tipoParametro == 1) {
                    return 'Cumpleaños';
                } elseif ($model->tipoParametro == 2) {
                    return 'Aniversario';
                } elseif ($model->tipoParametro == 3) {
                    return 'Contenido';
                } elseif ($model->tipoParametro == 4) {
                    return 'Curso';
                } elseif ($model->tipoParametro == 999) {
                    return 'Misiones de Compra';
                }
            },
            'filter'=>array('1' => 'Cumpleaños', '2' => 'Aniversario', '3' => 'Contenido', '4' => 'Curso', '999' => 'Misiones de Compra'),
        ],
    ],
]); ?>