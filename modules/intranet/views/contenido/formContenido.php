<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\intranet\models\ContenidoDestino;
?>


<div class="modal fade" id="modal-contenido-publicar" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Noticia a publicar</h4>
      </div>
      <?php
      $form = ActiveForm::begin([
        'id' => 'form-contenido-publicar',
        'action' => 'intranet/contenido/publicar',
        'method' => 'POST',
        'enableClientValidation' => true,
        'options' => [
          'enctype' => 'multipart/form-data',
          'data-pjax' => true
        ],
      ]);
      ?>
      <div class="modal-body">

        <?php echo $form->field($objContenido, 'titulo')->input(['value' => 1]); ?>
        <?php
        echo $form->field($objContenido, 'contenido')->widget(Widget::className(), [
          'id' => "post_" . $objLineaTiempo->idLineaTiempo,
          'settings' => [
            'lang' => 'es',
            'minHeight' => 200,
            'imageUpload' => Url::toRoute('sitio/cargar-imagen'),
            'fileUpload' => Url::toRoute('sitio/cargar-archivo'),
            'plugins' => [
              'imagemanager',
              'fullscreen'
            ],
            'fileManagerJson' => Url::to(['sitio/files-get']),
          ]
          ])->label(false);
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
              <?php echo $this->render('_formDestinoContenido', ['objContenidoDestino' => new ContenidoDestino]) ?>
            </div>
          <?php endif; ?>

          <?= Html::hiddenInput("Contenido[idLineaTiempo]", $objLineaTiempo->idLineaTiempo, ["id" => "idLineaTiempo"]); ?>
          <?= Html::hiddenInput("SolicitarGrupoObjetivo", $objLineaTiempo->solicitarGrupoObjetivo, ["id" => "SolicitarGrupoObjetivo"]); ?>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <?php $requiere = ($objLineaTiempo->autorizacionAutomatica == 0) ? ' (Requiere aprobación)' : ''; ?>
            <?= Html::a(Yii::t('app', 'Publicar Noticia' . $requiere), '#', ['class' => 'btn btn-primary', 'data-role' => 'guardar-contenido', 'data-href' => "#lt$objLineaTiempo->idLineaTiempo", 'id' => 'btnAgregarContenido']) ?>
          </div>

          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
