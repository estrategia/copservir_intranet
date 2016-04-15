<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>


<div class="modal fade" id="modal-contenido-denuncio" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Denunciar</h4>
            </div>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'form-contenido-denuncio',
                        'method' => 'POST',
                        'enableClientValidation' => true,
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'data-pjax' => true
                        ],
            ]);
            ?>
            <div class="modal-body">

                <?php echo $form->field($modelDenuncio, 'descripcionDenuncio')->textarea(['rows' => 3]); ?>

                <?= Html::hiddenInput("DenunciosContenidos[idContenido]", $modelDenuncio->idContenido, ["id" => "idContenido"]); ?>

                <?= Html::hiddenInput("idLineaTiempo", $idLineaTiempo, ["id" => "idLineaTiempo"]); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                 <?= Html::button(Yii::t('app', 'Denunciar' ), ['class' => 'btn btn-primary', 'data-role' => 'guardar-denuncio-contenido', 'data-linea-tiempo' => $idLineaTiempo]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
