<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\CursoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programas';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger" role="alert">
      <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-info" role="alert">
      <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>
<div class="curso-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Programa', ['crear'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'tipoCurso',
                'filter' =>
                Html::activeDropDownList($searchModel, 'tipoCurso', ['1' => 'Obligatorio', '0' => 'Opcional'],
                        ['class'=>'form-control','prompt' => 'Seleccione']),
                        'value' => function($model) {
                          if ($model->tipoCurso == 1) {
                            return 'Obligatorio';
                          } elseif ($model->tipoCurso == 0) {
                            return 'Opcional';
                          }
                }
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['detalle', 'id' => $model->idCurso]) .'">Detalle</a>';
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['actualizar', 'id' => $model->idCurso]) .'">Actualizar</a>';
                },
            ],
            // [
            //     'attribute' => '',
            //     'format' => 'raw',
            //     'value' => function ($model) {                      
            //         return $model->estadoCurso == 0 ? '<a class="btn btn-default" href="'. Url::to(['activar', 'id' => $model->idCurso]) .'">Activar</a>' : '';
            //     },
            // ],
        ],
    ]); ?>
</div>
