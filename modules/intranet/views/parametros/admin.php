<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Parametros';
$this->params['breadcrumbs'][] = ['label' => 'Parametros de aplicación'];
?>

<div class="parametros-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
        ],
        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idParametro',
            'descripcion',
            'valorParametro',
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{actualizar}',
              'buttons' => [
                'actualizar' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                },
              ],
            ],
        ],
    ]); ?>
</div>
