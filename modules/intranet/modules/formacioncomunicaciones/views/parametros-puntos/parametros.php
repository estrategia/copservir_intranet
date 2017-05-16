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
                    return 'Tipo Contenido';
                } elseif ($model->tipoParametro == 2) {
                    return 'Cumpleaños';
                } elseif ($model->tipoParametro == 3) {
                    return 'Aniversario';
                } elseif ($model->tipoParametro == 999) {
                    return 'Siicop';
                }
            },
            'filter'=>array('1' => 'Tipo Contenido', '2' => 'Cumpleaños', '3' => 'Aniversario', '999' => 'Siicop'),
        ],
        'valorPuntos',
        // 'idTipoContenido',
        'condicion',
        [
            'attribute' => 'idTipoContenido',
            'filter' =>
            Html::activeDropDownList($searchModel, 'idTipoContenido', ArrayHelper::map($tiposContenidos, 'idTipoContenido','nombreTipoContenido'),
                    ['class'=>'form-control','prompt' => 'Seleccione']),
                    'value' => function($model) {
                    return is_null($model->idTipoContenido) ? 'Sin tipo' : $model->objTipoContenido->nombreTipoContenido;
            }
        ],

        // 'estado',
        // 'fechaCreacion',
        // 'fechaActualizacion',
        // 'valorPuntosExtra',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>