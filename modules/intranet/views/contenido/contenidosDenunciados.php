<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Contenidos denunciados';
?>
<div class="col-md-12">

  <div class="col-md-12">
    <div class="grid simple">
      <div class="grid-title no-border" style='background-color:#0AA699 !important'>
        <h3 style='color:#fff !important;'> <?= Html::encode($this->title) ?> <span class="semi-bold"></span></h3>
        <div class="tools"></div>
      </div>

      <div class="grid-body no-border">
        <?php Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'tableOptions' =>['class' => 'table table-hover no-more-tables'],
          'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'titulo',
            'fechaPublicacion',
            [
              'attribute' => 'idLineaTiempo',
              'label' => 'Linea de tiempo',
              'value' => function($model) {
                return $model->objLineaTiempo->nombreLineaTiempo;
              }
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle-denuncio} ',
              'buttons' => [
                'detalle-denuncio' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                },
              ],
            ],

          ],
        ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>
  </div>


</div>
