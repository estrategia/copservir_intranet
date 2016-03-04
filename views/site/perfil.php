<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<p>&nbsp;&nbsp;</p>
<div class="tiles-body">
    <div class="row">
        <div class="info">
            <div class="col-md-6">
                <div >
                    <img class="user-profile-pic" alt="" src="<?= Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->imagenPerfil ?>" >
                </div>
                <?php
                $form = ActiveForm::begin([
                            "method" => "post",
                            "enableClientValidation" => true,
                            "options" => ["enctype" => "multipart/form-data"],
                ]);
                ?>
                <?= $form->field($modelFoto, "imagenPerfil")->fileInput(['multiple' => false]) ?>
                <?= Html::submitButton("Subir Foto", ["class" => "btn btn-primary btn-sm"]) ?>
                <?php $form->end() ?>
<br/>                
<?= Html::a('Actualizar datos', ['/site/actualizar-datos'], ['class' => 'btn btn-primary btn-sm', 'name' => 'forgot-button']) ?> 
<?= Html::a('Cambiar contraseña', ['/site/cambiar-clave'], ['class' => 'btn btn-primary btn-sm', 'name' => 'forgot-button']) ?> 
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="post col-md-12">

            <div class="info-wrapper">          

                <div class="info">
                    <div class="post col-md-6">
                        <h5>Información General</h5>
                        <b>Profesión:</b> <?= \Yii::$app->user->identity->getProfesion() ?> <br>
                        <b>Cargo:</b> <?= \Yii::$app->user->identity->getCargo() ?> <br>
                        <b>Area:</b> <?= \Yii::$app->user->identity->getArea() ?> <br>
                        <b>Vinculación:</b> <?= \Date("Y-m-d", \Yii::$app->user->identity->getVinculacion()) ?> <br>
                        <b>Antiguedad:</b> <?= \Yii::$app->user->identity->getAntiguedad() ?> <br>
                        <b>Jefe Inmediato:</b><?= \Yii::$app->user->identity->getJefeInmediato() ?>
                    </div>
                    <div class="post col-md-6">
                        <h5>Educación</h5>
                        <b>Superiores:</b> <?= \Yii::$app->user->identity->getSuperiores() ?>
                        <h5>Otra Información</h5>
                        <b>Extensión:</b> <?= \Yii::$app->user->identity->getExtension() ?><br>
                        <b>eMail:</b> <?= \Yii::$app->user->identity->getEmail() ?><br>
                        <b>Celular:</b> <?= \Yii::$app->user->identity->getCelular() ?><br>
                        <b>Residencia:</b> <?= \Yii::$app->user->identity->getResidencia() ?><br>
                        <b>Ciudad:</b> <?= \Yii::$app->user->identity->getCiudad() ?><br>
                        <b>Cumpleaños:</b> <?= \Yii::$app->user->identity->getCumpleanhos() ?>
                    </div>   
                </div>  



            </div>  
            <div class="clearfix"></div>  
            <br>
            <br>
        </div>
    </div>
</div>