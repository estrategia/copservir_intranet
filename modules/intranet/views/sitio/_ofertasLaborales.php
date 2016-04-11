<?php
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>


<div class="col-md-8">
    <br><br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple ">
                <div class="grid-title no-border" style='background-color:#0AA699 !important'>
                    <h4 style='color:#fff !important;'>Ofertas <span class="semi-bold">Laborales</span></h4>
                    <div class="tools">
                        <a href="javascript:;" data-role="quitar-elemento" data-elemento="<?=\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_OFERTAS?>" class="remove"></a>
                    </div>
                </div>
                <div class="grid-body no-border">
                    <p>La Oficina de Talento Humano ...</p>
                    <?php if (!empty($ofertasLaborales)): ?>
                      <?php Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
                      <?= GridView::widget([
                          'dataProvider' => $ofertasLaborales,
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
                              [
                                'attribute' => 'idArea',
                                'value' => function($model) {
                                  return $model->objArea->nombreArea;
                                }
                              ],

                              [
                                'class' => 'yii\grid\ActionColumn',
                              	'template' => '{link}',
                              	'buttons' => [
                              		'link' => function ($url,$model,$key) {
                              				return Html::a('Postularse', 'urlElEmpleo:url',['class'=>'btn btn-xs btn-primary ']);
                              		},
                              	],
                              ],

                              // 'idCargo',
                              // 'idArea',

                               //'idInformacionContacto',

                              //['class' => 'yii\grid\ActionColumn'],
                          ],
                      ]); ?>
                      <?php Pjax::end(); ?>
                    <?php endif; ?>
                    <?=
                        Html::a('Ver todos',  ['ofertas-laborales/listar-ofertas'], [
                            'class' => 'btn btn-block btn-primary',
                        ]);
                     ?>

                </div>
            </div>
        </div>
    </div>
</div>
