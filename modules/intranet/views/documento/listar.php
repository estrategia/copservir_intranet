<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\Documento;

$this->title = 'Documentos';
$this->params['breadcrumbs'][] = ['label' => 'Documentos organizacionales'];
?>
<div class="documento-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Crear un documento', ['crear'], ['class' => 'btn btn-success']) ?>
  </p>
  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      'titulo',
      'descripcion',
      [
        'label'=>'Descargar',
        'attribute' => 'rutaDocumento',
        'format'=>'raw',
        'value' => function($model) {
          return Html::a('<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>', Yii::getAlias('@web') . Yii::$app->params['documentos']['rutaArchivo'] .$model->rutaDocumento, ['target'=>'_blank']);
        }
      ],
      [
        'attribute' => 'estado',
        'filter' =>
          Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
            ['class'=>'form-control','prompt' => 'Selecciones']),
        'value' => function($model) {
          if ($model->estado == Documento::ESTADO_ACTIVO ) {
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
