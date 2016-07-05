<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\UsuarioTarjetaMas */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Registro de Datos';
?>

<div class="container">
    <div class="space-2"></div>
    <div class="space-2"></div>
    <div class="row">
        <div class="col-md-12">

            <h2><?= Html::encode($this->title) ?></h2>

            <?= $this->render('/common/errores', []) ?>

            <div class="space-1"></div>

            <div class="col-md-offset-3 col-md-6">
                <?php $form = ActiveForm::begin(['options' => ['id' => 'formMenuportales']]); ?>

                <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'primerApellido')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'segundoApellido')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'numeroDocumento')->textInput(['maxlength' => true]) ?>

                <?=
                $form->field($model, 'codigoCiudad')->widget(Select2::classname(), [
                    'data' => $model->getListaCiudad(),
                    'options' => ['placeholder' => 'Seleccione la ciudad']
                ]);
                ?>

                <?= $form->field($model, 'correo')->input('email') ?>

                <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'telefonoFijo')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'password', [])->passwordInput(); ?>

                <?= $form->field($model, 'aceptaTerminos', [])->checkbox(); ?>

                <div class="col-md-3">
                    <div class="form-group">
                        <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                    $modal = Modal::begin([
                                'header' => '<h2>Términos y condiciones</h2>',
                                'toggleButton' => ['label' => 'Ver terminos y condiciones', 'class' => 'btn btn-primary'],
                    ]);
                    ?>

                    <?= 'Los terminos'; ?>

                    <?php $modal::end(); ?>
                </div>


                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="space-2"></div>
    <div class="space-2"></div>
</div>
