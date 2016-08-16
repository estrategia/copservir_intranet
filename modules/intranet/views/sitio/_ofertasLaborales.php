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
            <a href="javascript:;" data-role="quitar-elemento" data-elemento="<?= \app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_OFERTAS ?>" class="remove"></a>
          </div>
        </div>
        <div class="grid-body no-border">
          <p>La Oficina de Talento Humano ...</p>
          <?php if (!empty($ofertasLaborales)): ?>
            <?php Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
            <?=
            GridView::widget([
              'dataProvider' => $ofertasLaborales,
              'pager' => [
                'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
              ],
              'layout' => "{summary}\n{items}\n<center>{pager}</center>",
              'tableOptions' => ['class' => 'table table-hover no-more-tables'],
              'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'nombreCargo',
                [
                  'attribute' => 'idCiudad',
                  'value' => function($model) {
                    return $model->objCiudad->nombreCiudad;
                  }
                ],
                'fechaPublicacion',
                [
                  'class' => 'yii\grid\ActionColumn',
                  'template' => '{link}',
                  'buttons' => [
                    'link' => function ($url, $model, $key) {
                      return Html::a('Postularse', $model->urlElEmpleo, ['target' => '_blank', 'class' => 'btn btn-xs btn-primary ']);
                    },
                  ],
                ],
                [
                  'class' => 'yii\grid\ActionColumn',
                  'template' => '{contacto}',
                  'buttons' => [
                    'contacto' => function ($url, $model, $key) {
                      return Html::a('contacto', '#', ['class' => 'btn btn-xs btn-primary', 'data-html' => 'true', 'data-content' => '',
                      'role' => "button", 'data-toggle' => "popover", 'data-trigger' => "focus", 'data-placement' => "right",
                      'data-role' => "contacto-oferta", 'data-oferta' => $model->idInformacionContacto]);
                    },
                  ],
                ],
              ],
            ]);
            ?>
            <?php Pjax::end(); ?>
          <?php endif; ?>
          <?=
          Html::a('Ver todas las ofertas laborales', ['ofertas-laborales/listar-ofertas'], [
            'class' => 'btn btn-block btn-primary',
          ]);
          ?>

        </div>
      </div>
    </div>
  </div>
</div>
