<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parametros';
$this->params['breadcrumbs'][] = ['label' => 'Parametros - Puntos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Crear Parametro', ['crear'], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [

        'idParametroPunto',
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
            'filter'=>array('1' => 'Cumpleaños', '2' => 'Aniversario', '999' => 'Externo'),
        ],
        'valorPuntos',
        // 'idTipoContenido',
        'condicion',
        // 'estado',
        // 'fechaCreacion',
        // 'fechaActualizacion',
        // 'valorPuntosExtra',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>