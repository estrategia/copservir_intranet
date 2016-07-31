<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Roles';
$this->params['breadcrumbs'][] = ['label' => 'Roles'];
?>
<div class="linea-tiempo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea un nuevo rol', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description',
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
