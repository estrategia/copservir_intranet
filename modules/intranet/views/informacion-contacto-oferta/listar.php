<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\InformacionContactoOferta;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\InformacionContactoOfertaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plantillas';
$this->params['breadcrumbs'][] = ['label' => 'Plantilla ofertas laborales'];
?>
<div class="informacion-contacto-oferta-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
    <?= Html::a('Crea una plantilla', ['crear'], ['class' => 'btn btn-success']) ?>
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

      'nombrePlantilla',
      'plantillaContactoHtml:ntext',
      [
        'attribute' => 'estado',
        'filter' =>
          Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
            ['class'=>'form-control','prompt' => 'Seleccione']),
        'value' => function($model) {
          if ($model->estado == InformacionContactoOferta::PLANTILLA_ACTIVA ) {
            return 'Activo';
          }else{
            return 'Inactivo';
          }
        }
      ],
      'fechaRegistro',
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
