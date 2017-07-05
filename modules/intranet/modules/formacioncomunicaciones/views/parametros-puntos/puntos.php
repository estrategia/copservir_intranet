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
            'attribute' => 'objUsuario',
            'label' => 'Usuario',
            'value' => 'objUsuario.nombres',
            'filter' => Html::activeInput('text', $searchModelPuntos, 'usuario'),
        ],
        [
            'attribute' => 'tipoParametro',
            'value'  => function ($model)
            {
                if ($model->tipoParametro == 1) {
                    return 'Cumpleaños';
                } elseif ($model->tipoParametro == 2) {
                    return 'Aniversario';
                } elseif ($model->tipoParametro == 999) {
                    return 'Externo';
                }
            },
            'filter'=>array('1' => 'Tipo Contenido', '2' => 'Cumpleaños', '3' => 'Aniversario', '999' => 'Externo'),
        ],
    ],
]); ?>