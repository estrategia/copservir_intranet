<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Ofertas Laborales';
?>
<div class="col-md-12">

    <div class="col-md-12">
        <div class="grid simple">
          <div class="grid-title no-border" style='background-color:#0AA699 !important'>
              <h2 style='color:#fff !important;'>Ofertas <span class="semi-bold">Laborales</span></h2>
              <div class="tools">
                  <!--<a href="javascript:;" class="collapse"></a>
                  <a href="#grid-config" class="config"></a>
                  <a href="javascript:;" class="reload"></a>
                  <a href="javascript:;" class="remove"></a>-->
              </div>
          </div>

          <div class="grid-body no-border">
            <?php Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' =>['class' => 'table table-hover no-more-tables'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'idOfertaLaboral',
                    [
                      'attribute' => 'idCargo',
                      'value' => function($model) {
                        return $model->objCargo->nombreCargo;
                      }
                    ],
                    //'idContenidoDestino',
                    [
                      'attribute' => 'idCiudad',
                      'value' => function($model) {
                        return $model->objCiudad->nombreCiudad;
                      }
                    ],
                    'fechaPublicacion',
                    // 'fechaCierre',
                    // 'idUsuarioPublicacion',
                    // 'fechaInicioPublicacion',
                    // 'fechaFinPublicacion',
                    'tituloOferta',
                    'descripcionContactoOferta:ntext',
                    'urlElEmpleo:url',
                    // 'idCargo',
                    // 'idArea',

                     //'idInformacionContacto',

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
          </div>
        </div>
    </div>


</div>
