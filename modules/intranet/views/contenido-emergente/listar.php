<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\ContenidoEmergente;

$this->title = 'Contenido Emergente';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contenidos emergentes')];
?>
<div class="contenido-emergente-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Crea un contenido emergente', ['crear'], ['class' => 'btn btn-success']) ?>
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
      'contenido:ntext',
      'fechaInicio',
      'fechaFin',
      [
        'attribute' => 'estado',
        'filter' =>
          Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
            ['class'=>'form-control','prompt' => 'Selecciones']),
        'value' => function($model) {
          if ($model->estado == ContenidoEmergente::ESTADO_ACTIVO ) {
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
