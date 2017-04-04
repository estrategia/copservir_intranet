<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\CursoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cursos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curso-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Curso', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombreCurso',
            'presentacionCurso',
            'fechaInicio',
            'fechaFin',
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['view', 'id' => $model->idCurso]) .'">Detalle</a>';
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['update', 'id' => $model->idCurso]) .'">Actualizar</a>';
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return $model->estadoCurso == 0 ? '<a class="btn btn-default" href="'. Url::to(['activar', 'id' => $model->idCurso]) .'">Activar</a>' : '';
                },
            ],
        ],
    ]); ?>
</div>
