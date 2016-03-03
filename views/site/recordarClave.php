<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Recuperación contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <p>Por favor digita tu identificación:</p>

    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
    ]);
    ?>

    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'captcha')->widget(Captcha::className())->label("") ?>
    <div class="s"
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Enviar recuperación', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
