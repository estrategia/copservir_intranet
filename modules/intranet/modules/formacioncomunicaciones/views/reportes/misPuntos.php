<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Puntos';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProviderPuntos,
    'filterModel' => $searchModelPuntos,
    'columns' => [

        'idPunto',
        [
                'attribute' => '',
                'label' => 'Programa / Curso',
                'value' => function ($model) { 
                    return $model->objCuestionario->idContenido == null ? 
                    $model->objCuestionario->objCurso->nombreCurso : 
                    $model->objCuestionario->objContenido->tituloContenido;
                },
                'filter' => Html::activeInput('text', $searchModelPuntos, 'tituloCurso', ['class' => 'form-control']),                
            ],
        'descripcionPunto',
        'valorPuntos',
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

<button class="btn btn-default" data-role="ver-puntos-usuario">Ver totales</button>