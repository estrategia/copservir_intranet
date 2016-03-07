<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

  $this->title = 'Login';

?>

<div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
  <h2 class="normal">
    Ingresar Intranet
  </h2>
  <p>
    Utilice sus credenciales de acceso...<br>
  </p>
</div>

<div class="tiles grey p-t-20 p-b-20 no-margin text-black tab-content">
  <div role="tabpanel" class="tab-pane active" id="tab_login">
    <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
      <?php $form = ActiveForm::begin([
          'id' => 'login-form',
          'options' => ['class' => 'animated fadeIn validate'],
          'fieldConfig' => [
              'template' => "<div class=\"col-md-4 col-sm-4\">{input}</div>\n{error}",
              'labelOptions' => ['class' => 'col-lg-1 control-label'],
          ],
      ]); ?>

        <?= $form->field($model, 'username', [
            'inputOptions' => [
                  'placeholder' => $model->getAttributeLabel('username'),
            ],
        ])->label(false); ?>

        <?= $form->field($model, 'password', [
            'inputOptions' => [
                  'placeholder' => $model->getAttributeLabel('password'),
            ],
        ])->label(false)->passwordInput(); ?>

        <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary pull-right', 'name' => 'login-button']) ?>


    </div>

    <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
        <div class="control-group col-md-10">
          <div class="checkbox checkbox check-success">
            <div class="form-group ">
                <?= Html::a('Olvide mi contraseña', 'recordar-clave', [ ]); ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "{input} {label}</div>\n{error}",
                ]) ?>

            </div>


          </div>
        </div>
    </div>
      <?php ActiveForm::end(); ?>

  </div>
</div>
