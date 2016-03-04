<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

  $this->title = 'Login';

?>

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

<<<<<<< HEAD
  </div>

  <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
      <div class="control-group col-md-10">
        <div class="checkbox checkbox check-success">
          <div class="form-group ">
              <?= Html::a('Olvide mi contraseña', '#', [ ]); ?>

              <?= $form->field($model, 'rememberMe')->checkbox([
                  'template' => "{input} {label}</div>\n{error}",
              ]) ?>
=======
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?= Html::a('Olvidé mi contraseña',['/site/recordar-clave'], ['class' => 'btn btn-primary', 'name' => 'forgot-button']) ?>
            </div>
        </div>
>>>>>>> e1891580887007f4b4dfcf66d4b23923522519c4

          </div>


        </div>
      </div>
  </div>
    <?php ActiveForm::end(); ?>

</div>
