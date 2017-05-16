<?php

use yii\widgets\ListView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\datetime\DateTimePicker;

$this->title = 'Todas las noticias';

?>
<div class="space-2"></div>
<div class="space-2"></div>


<div class="container internal text-left">
  <section>
    <div class="white-item">
      <div id="w0-filters" class="filters">
        <?php $form = ActiveForm::begin(); ?>

        <!-- <?=
        $form->field($searchModel, 'fechaInicioPublicacion')->widget(DateTimePicker::classname(), [
          'options' => ['placeholder' => 'busque una noticia por fecha'],
          'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
          ]
          ])->label(false);
        ?> -->

        <!--<div class="form-group">
          <?php //Html::submitButton('Buscar', ['class' => 'btn btn-success']) ?>
        </div>-->
        <?php ActiveForm::end(); ?>
      </div>

      <section class="gray-sec centered">
        <div class="marketing">
          <h2>Noticias</h2>
          <div class="row">
            <?=
            ListView::widget([
              'dataProvider' => $dataProviderNoticias,
              'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
              ],
              // 'layout' => "{summary}\n{items}\n<div class='col-md-4 col-md-offset-8'>{pager}</div>",
              'itemView' => function ($model, $var, $index, $widget) {
                return $this->render('_plantillaNoticia', ['modelContenido' => $model]);
              },
              'itemOptions' => [
                'tag' => false,
              ],
              'pager' => [
                'nextPageLabel' => 'Siguiente',
                'prevPageLabel' => 'Anterior',
                'maxButtonCount' => 5,
              ],
            ]);
            ?>
          </div>
        </div>
      </section>

    </div>
  </section>
</div>

<div class="space-2"></div>
