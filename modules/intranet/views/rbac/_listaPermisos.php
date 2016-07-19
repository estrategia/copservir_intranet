<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>
<div class="col-md-12 permisos">

  <h4>asigne un permiso al rol</h4>
  <!-- formulario para asignar permiso -->
  <?php Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
  <?php $form = ActiveForm::begin(['options' => ['id'=> 'formAuthItemChild', 'data-pjax' => '']]); ?>
  <div class="col-md-6">
    <?php

      echo $form->field($authItemChild, 'child')->widget(Select2::classname(), [
        'data' => $model->getListaPermisos(),
        'options' => ['placeholder' => 'Seleccione un permiso'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
      ])->label(false);

    ?>

    <?= $form->field($authItemChild, 'parent')->hiddenInput(['value'=> $model->name])->label(false); ?>

  </div>
  <div class="col-md-6">
    <div class="form-group">
      <?= Html::submitButton('Asignar permiso', ['class' => 'btn btn-primary', 'data-role' => 'agregar-permiso-rol']) ?>
    </div>
  </div>

  <?php ActiveForm::end(); ?>

  <?= $this->render('/common/errores', []) ?>

  <?= GridView::widget([
      'dataProvider' => $dataProviderPermisos,
      'filterModel' => $searchModel,
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'child',
          [
            'attribute' => 'description',
            'label'=>'Descripcion',
            'value' => 'objChild.description',
          ],
          [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions'=> ['style'=>'width: 70px;'],
            'template' => '{quitar-permiso}',
            'buttons' => [
              'quitar-permiso' => function ($url, $model) {
                return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'class' => 'btn btn-danger',
                            'data-permiso-parent' => $model->parent,
                            'data-permiso-child' => $model->child,
                            'data-role' => 'eliminarPemisoRol'
                                ]);
              }
            ],
          ],
      ],
  ]); ?>

<?php Pjax::end(); ?>
</div>
