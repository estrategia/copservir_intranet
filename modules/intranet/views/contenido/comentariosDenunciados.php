<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Comentarios denunciados';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comentarios denunciados')];
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
          'pager' => [
            'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
          ],
          'layout' => "{summary}\n{items}\n<center>{pager}</center>",
          'tableOptions' =>['class' => 'table table-hover no-more-tables'],
          'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'idContenido',
              'label' => 'Noticia del comentario',
              'value' => function($model) {
                return $model->objContenido->titulo;
              }
            ],
            [
              'attribute' => 'contenido',
              'label' => 'contenido del comentario',
              'format'=>'raw',
              'value' => function($model) {
                return $model->contenido;
              }
            ],
            [
              'label' => 'Motivo',
              'value' => function($model) {
                return $model->objDenuncioComentario->descripcionDenuncio;
              }
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle-comentario-denuncio} ',
              'buttons' => [
                'detalle-comentario-denuncio' => function ($url, $model) {
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
