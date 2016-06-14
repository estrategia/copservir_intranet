<?php
use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\intranet\models\ContenidoDestino;
use app\modules\intranet\models\Parametros;
use kartik\file\FileInput;

$maxFileCount = Parametros::obtenerValorParametro('contenido_maxFileCount');
$maxFileSize = Parametros::obtenerValorParametro('contenido_maxFileSize');

?>

<div class="col-md-12">


  <?php
  $form = ActiveForm::begin([
    'id' => 'form-contenido-publicar',
    'enableAjaxValidation' => true,
    'options'=>['encytype'=>'multipart/form-data']
  ]);
  ?>


  <?php echo $form->field($objContenido, 'titulo')->input(['value' => 1]); ?>
  <?php
  echo $form->field($objContenido, 'contenido')->widget(Widget::className(), [
    'id' => "post_" . $objLineaTiempo->idLineaTiempo,
    'settings' => [
      'lang' => 'es',
      'minHeight' => 100,
      'buttons' => ['format', 'bold', 'italic'],
      //'imageUpload' => Url::toRoute('contenido/cargar-imagen'),
      'fileUpload' => Url::toRoute('contenido/cargar-archivo'),
      'plugins' => [
        //'imagemanager',
        'fullscreen'
      ],
      'fileManagerJson' => Url::to(['sitio/files-get']),
    ]
    ])->label(false);
    ?>

    <?php
    echo FileInput::widget([
      'name'=> 'imagen[]',
      'id' => 'contenido-imagenes',
      'options' => ['multiple' => true, 'accept' => 'image/*'],
      'pluginOptions' => [
        'uploadAsync'=>false,
        'maxFileCount' => $maxFileCount,
        'validateInitialCount'=> true,
        'maxFileSize' => $maxFileSize,
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

    <?php if ($objLineaTiempo->solicitarGrupoObjetivo == 1): ?>
      <?=
      Html::a('<i class = "fa fa-plus-square" ></i>', '#', [
        'data-role' => 'agregar-destino-contenido',
        'title' => 'Agregar nuevo'
      ]);
      ?>
      <?= Html::label('Añadir otro') ?>
      <div id="contenido-destino">
        <?php echo $this->render('_formDestinoContenido', ['objContenidoDestino' => new ContenidoDestino, 'consultaTodos' => true]) ?>
      </div>
    <?php endif; ?>

    <?= Html::hiddenInput("Contenido[idLineaTiempo]", $objLineaTiempo->idLineaTiempo, ["id" => "idLineaTiempo"]); ?>
    <?= Html::hiddenInput("SolicitarGrupoObjetivo", $objLineaTiempo->solicitarGrupoObjetivo, ["id" => "SolicitarGrupoObjetivo"]); ?>

    <?php $requiere = ($objLineaTiempo->autorizacionAutomatica == 0) ? ' (Requiere aprobación)' : ''; ?>
    <?= Html::a(Yii::t('app', 'Publicar Noticia' . $requiere), '#', ['class' => 'btn btn-primary btn-small', 'data-role' => 'guardar-contenido', 'data-href' => "#lt$objLineaTiempo->idLineaTiempo", 'id' => 'btnAgregarContenido']) ?>


    <?php ActiveForm::end(); ?>

</div>
