<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\modules\formacioncomunicaciones\models\Cuestionario;
use app\modules\intranet\modules\formacioncomunicaciones\models\Pregunta;
use yii\helpers\ArrayHelper;

$this->title = 'Formacion comunicacion';
$this->params['breadcrumbs'][] = ['label' => 'Cuestionario'];
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear pregunta', ['crear-pregunta', 'idCuestionario' => $modelCuestionario->idCuestionario], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
        ],
        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tituloPregunta',
            [
              'attribute' => 'idTipoPregunta',
              'filter' =>
                Html::activeDropDownList($searchModel, 'idTipoPregunta', ArrayHelper::map($tipoPreguntas, 'idTipoPregunta','tipoPregunta'),
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                return $model->objTipoPregunta->tipoPregunta; 
              }
            ],
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->estado == Pregunta::ESTADO_ACTIVO ) {
                  return 'Activo';
                }else{
                  return 'Inactivo';
                }
              }
            ],
            'fechaCreacion',
            'fechaActualizacion',

            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle-pregunta} {actualizar-pregunta} {eliminar-pregunta}',
              'buttons' => [
                'detalle-pregunta' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', ['data-role' => 'visualizar-pregunta', 'data-pregunta' => $model->idPregunta]);
                },
                'actualizar-pregunta' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                },
                'eliminar-pregunta' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                }
              ],
            ],
        ],
    ]); ?>
</div>