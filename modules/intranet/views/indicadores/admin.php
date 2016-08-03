<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\Indicadores;

$this->title = 'Indicadores';
$this->params['breadcrumbs'][] = ['label' => 'Administrar indicadores'];
?>

<div class="row">
  <div class="col-lg-12">
    <?php foreach (Yii::$app->session->getAllFlashes() as $tipo => $mensaje): ?>
      <div role="alert" class="alert alert-<?= $tipo ?> alert-dismissible fade in">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
        <p><?= $mensaje ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="indicadores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea Indicadores', ['crear'], ['class' => 'btn btn-success']) ?>
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
            'descripcion',
            'valor',
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->estado == Indicadores::ESTADO_ACTIVO ) {
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
