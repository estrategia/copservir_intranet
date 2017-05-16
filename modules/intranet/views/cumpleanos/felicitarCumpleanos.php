<?php
  use vova07\imperavi\Widget;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  use yii\helpers\Html;
  use kartik\file\FileInput;


  $this->title = 'Felicitar Cumpleaños';
  $this->params['breadcrumbs'][] = ['label' => 'Cumpleaños', 'url' => ['/intranet/sitio/todos-cumpleanos']];
  $this->params['breadcrumbs'][] = $this->title
 ?>

<div class="col-md-12 center-block" id="div-felicitar">
  <div id="div-felicitar-alert"></div>
  <div class="grid simple horizontal green">
    <div class="grid-title  center-block">
      <h4 class="text-truncate-hover" style="width: 100%">
        Felicita a <?= $modelCumpleanosPersona->nombre  ?>  en su cumpleaños
      </h4>
    </div>
    <div class="grid-body center-block">

      <div class="col-md-4">
        <div class="circle-avatar" style="background-image:url(<?= Yii::getAlias('@web').'/img/fotosperfil/'. $modelCumpleanosPersona->objUsuario->getImagenPerfil() ?>)"></div>
      </div>

      <div class="col-md-6" style="border-left: 1px solid #eee;">
        <?php $form = ActiveForm::begin(['id'=>'form-cumpleanios' , 'options'=>['encytype'=>'multipart/form-data']]); ?>
        <?php
        echo $form->field($modelContenido, 'contenido')->widget(Widget::className(), [
          'settings' => [
            'lang' => 'es',
            'minHeight' => 100,
            'buttons' => ['format', 'bold', 'italic'],
            'plugins' => [
            ],

          ]
          ])->label(false);
          ?>

          <?php
          echo FileInput::widget([
            'name'=> 'imagen[]',
            'id' => 'contenido-imagenes',
            'options' => ['multiple' => true, 'accept' => 'image/*'],
            'pluginOptions' => [

              'maxFileCount' => 5,
              'validateInitialCount'=> true,
              'maxFileSize' => 5120,
              'previewFileType' => 'image',
              'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
              'browseLabel' =>  '',
              'showPreview' => true,
              'showCaption' => true,
              'showRemove' => true,
              'showUpload' => false,
              'uploadUrl' => Url::to(['/intranet/contenido/prueba']),
              'layoutTemplates' => [
                'actions' => '<div class="file-actions">' .
                            '    <div class="file-footer-buttons">' .
                              '        {delete}' .
                              '  </div>' .
                              '  <div class="clearfix"></div>' .
                              '</div>',
              ],
            ],
            'pluginLoading' => false,
      ]);
          ?>

          <?= Html::hiddenInput("numeroDocumentoDirigido", $modelCumpleanosPersona->numeroDocumento, []); ?>

        <br>
        <div class="form-group">
          <?= Html::submitButton('enviar', ['class' =>'btn btn-primary', 'data-role'=>'felicitar-cumpleanios', 'data-cumpleanios'=>$modelCumpleanosPersona->idCumpleanosPersona]) ?>
        </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>

  <?= $this->render('/common/errores', []) ?>

</div>
