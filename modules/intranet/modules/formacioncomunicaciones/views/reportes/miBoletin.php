<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\CursoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mi boletin';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Cuestionarios Aprobados</h1>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => '',
                'label' => 'Cuestionario',
                'value' => 'objCuestionario.tituloCuestionario',
                'filter' => Html::activeInput('text', $searchModel, 'nombreCuestionario', ['class' => 'form-control']),

            ],
            [
                'attribute' => '',
                'label' => 'Programa / Curso',
                'value' => function ($model) { 
                    return $model->objCuestionario->idContenido == null ? 
                    $model->objCuestionario->objCurso->nombreCurso : 
                    $model->objCuestionario->objContenido->tituloContenido;
                },
                'filter' => Html::activeInput('text', $searchModel, 'tituloCurso', ['class' => 'form-control']),                
            ],
            [
                'attribute' => '',
                'label' => 'Tipo Cuestionario',
                'value' => function ($model) { 
                    return $model->objCuestionario->idContenido == null ? 
                    'Programa' : 
                    'Curso';
                },
                'filter' =>
                    Html::activeDropDownList($searchModel, 'tipoCuestionario', ['1' => 'Programa', '0' => 'Curso'],
                        ['class'=>'form-control','prompt' => 'Seleccione'])
            ],
            'tiempoEmpleado',
            // 'numeroPreguntasRespondidas',
            'porcentajeObtenido',
            [
                'attribute' => '',
                'label' => 'Porcentaje Necesario',
                'value' => 'objCuestionario.porcentajeMinimo',

            ],
            // [
            //     'attribute' => '',
            //     'label' => 'Cuestionario',
            //     'value' => 'objCuestionario.tituloCuestionario',
                
            // ]
        ],
    ]); ?>