<?php 
  use yii\helpers\Html;
  use yii\bootstrap\ActiveForm;
?>

<div class="container internal">
  <div class="space-2"></div>
  <div class="space-2"></div>
  <div class="row">
    <div class="col-md-12">

      <div class="space-1"></div>

      <h4>Proveedores</h4>

      <div class="col-md-offset-4 col-md-4 autenticacion">

        <div class="space-1"></div>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'animated fadeIn validate'],
  ]); ?>

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

  <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary btn-sm btn-block', 'name' => 'login-button']) ?>

<?php ActiveForm::end(); ?>
  </div>

 </div>
     

    </div>
  </div>

  <div class="space-2"></div>
  <div class="space-2"></div>
</div>