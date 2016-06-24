<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
use app\modules\intranet\models\Ciudad;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = 'Actualizar Datos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-8">
  <div class="page-title">
    <h4>  Actualiza tu información personal</h4>
  </div>

  <?= $this->render('/common/errores', []) ?>

  <div class="grid simple">
    <div class="grid-title no-border">

    </div>
    <div class="grid-body no-border">

      <?php
      $form = ActiveForm::begin([]);
      ?>

      <?= $form->field($model, 'Nombres')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'PrimerApellido')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'SegundoApellido')->textInput(['maxlength' => true]) ?>

      <?=
          $form->field($model, 'FechaNacimiento')->widget(DatePicker::classname(), [
          'pluginOptions' => [
            'autoclose' => true,
            'format' => 'y-m-d'
          ]
        ]);
      ?>

      <?= $form->field($model, 'Direccion')->textInput(['maxlength' => true]) ?>

      <?=
        $form->field($model, 'IdCiudad')->widget(Select2::classname(), [
          'data' => ArrayHelper::map(Ciudad::find()->orderBy('nombreCiudad')->all(), 'codigoCiudad', 'nombreCiudad'),
          'options' => ['placeholder' => 'Seleccione el cargo de la oferta']
        ]);
      ?>

      <?= $form->field($model, 'Email')->input('email') ?>

      <?= $form->field($model, 'EmailPersonal')->input('email') ?>

      <div class="form-group">
          <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
      </div>
      <?php ActiveForm::end(); ?>

    </div>
  </div>
</div>
