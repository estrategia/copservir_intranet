<?php
  use vova07\imperavi\Widget;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  use yii\helpers\Html;
  use kartik\file\FileInput;

  $this->title = 'Aniversario';
 ?>

<div class="col-md-12 center-block" id="felicitar">
  <div class="grid simple horizontal green">
    <div class="grid-title  center-block">
      <h4>
        Felicita a <?= $modelCumpleanosLaboral->nombre  ?>  en su aniversario
      </h4>
    </div>
    <div class="grid-body center-block">

      <div class="col-md-4">
        <img class='img-circle img-responsive' src="<?= Yii::getAlias('@web').'/img/fotosperfil/'. $modelCumpleanosLaboral->objUsuario->imagenPerfil ?>" alt="Responsive">
        <br>

      </div>

      <div class="col-md-6" style="border-left: 1px solid #eee;">
        <?php $form = ActiveForm::begin(['id'=>'formAniversario' , 'options'=>['encytype'=>'multipart/form-data']]); ?>

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

          <?= Html::hiddenInput("numeroDocumentoDirigido", $modelCumpleanosLaboral->numeroDocumento, []); ?>
        <br>
        <div class="form-group">
          <?= Html::submitButton('enviar', ['class' =>'btn btn-primary', 'data-role'=>'felicitaAniversario', 'data-aniversario'=>$modelCumpleanosLaboral->idCumpleanosLaboral]) ?>
        </div>
        <?php ActiveForm::end(); ?>

      </div>
    </div>
  </div>
</div>
