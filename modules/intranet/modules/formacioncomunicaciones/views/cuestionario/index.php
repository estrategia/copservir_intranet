<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\modules\formacioncomunicaciones\models\Cuestionario;

$this->title = 'Formacion comunicacion';
$this->params['breadcrumbs'][] = ['label' => 'Cuestionario'];
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear cuestionario', ['crear'], ['class' => 'btn btn-success']) ?>
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

            'tituloCuestionario',
            'descripcionCuestionario',
            'tituloCuestionario',
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->estado == Cuestionario::ESTADO_ACTIVO ) {
                  return 'Activo';
                }else{
                  return 'Inactivo';
                }
              }
            ],
            

            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle} {actualizar} {eliminar}',
              'buttons' => [
                'detalle' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                },
                'actualizar' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                },
                'eliminar' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                }
              ],
            ],
        ],
    ]); ?>
</div>