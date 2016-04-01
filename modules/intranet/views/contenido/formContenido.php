<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\intranet\models\ContenidoDestino;
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
                        'imageUpload' => Url::toRoute('sitio/image-upload'),
                        'plugins' => [
                            //'clips',
                            'imagemanager',
                        ],
                    ]
                ])->label(false);
                ?>
                <?=
                Html::a('<i class = "fa fa-plus-square" ></i>', '#', [
                    //'id' => 'showFormPublications' . $linea->idLineaTiempo,
                    'data-role' => 'agregar-destino-contenido',
                    'title' => 'Agregar nuevo'
                ]);
                ?>
                <?= Html::label('Añadir otro') ?>
                <div id="contenido-destino">
                    <?php echo $this->render('_formDestinoContenido', ['objContenidoDestino' => new ContenidoDestino]) ?>
                </div>
                <?= Html::hiddenInput("Contenido[idLineaTiempo]", $objLineaTiempo->idLineaTiempo, ["id" => "idLineaTiempo"]); ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <?php $requiere = ($objLineaTiempo->autorizacionAutomatica == 0) ? ' (Requiere aprobación)' : ''; ?>
                    <?= Html::a(Yii::t('app', 'Publicar Noticia' . $requiere), '#', ['class' => 'btn btn-primary', 'data-role' => 'guardar-contenido', 'data-href' => "#lt$objLineaTiempo->idLineaTiempo"]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>