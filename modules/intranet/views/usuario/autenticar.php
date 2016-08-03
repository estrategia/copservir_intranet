<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>

<div class="tiles grey p-t-20 p-b-20 no-margin text-black tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab_login">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'animated fadeIn validate'],
                    'fieldConfig' => [
                        'template' => "<div style='padding:0px;' class=\"col-md-12 col-sm-12\">{input}</div>\n{error}",
                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],
                ]);
        ?>
        <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">


            <?=
            $form->field($model, 'username', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('username'),
                ],
            ])->label(false);
            ?>

            <?=
            $form->field($model, 'password', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('password'),
                ],
            ])->label(false)->passwordInput();
            ?>

            <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary btn-block btn-login', 'name' => 'login-button']) ?>
        </div>

        <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
            <div class="control-group col-md-12">
                <div class="checkbox checkbox check-success">
                    <div class="form-group ">
                        <?= Html::a('¿cambiar contraseña?', 'recordar-clave', []); ?>
                        <?= $form->field($model, 'rememberMe')->checkbox(['template' => "{input} {label}</div>\n{error}"]) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
