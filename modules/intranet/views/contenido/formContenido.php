<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>


<div class="modal fade" id="modal-contenido-publicar" tabindex="-1" role="dialog">
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
                        //'enableAjaxValidation' => true,
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
                        'imageUpload' => Url::toRoute('site/image-upload'),
                        'plugins' => [
                            //'clips',
                            'imagemanager',
                        ],
                    ]
                ])->label(false);
                ?>
                <?= Html::hiddenInput("Contenido[idLineaTiempo]", $objLineaTiempo->idLineaTiempo, ["id" => "idLineaTiempo"]); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <?php $requiere = ($objLineaTiempo->autorizacionAutomatica == 0) ? ' (Requiere aprobación)' : ''; ?>
                <?= Html::submitButton(Yii::t('app', 'Publicar Noticia' . $requiere), ['class' => 'btn btn-primary', 'data-role' => 'guardar-contenido']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
