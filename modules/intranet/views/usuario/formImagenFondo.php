<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use bupy7\cropbox\Cropbox;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perfil de usuario'), 'url'=>['/intranet/usuario/perfil']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imagen de fondo')];

?>

<?= $this->render('/common/errores', []) ?>

<?php

  $form = ActiveForm::begin([
      "method" => "post",
      "enableClientValidation" => true,
      "options" => ["enctype" => "multipart/form-data"],
    ]);
  ?>

  <?= $form->field($modelFoto, "imagenFondo")->fileInput(['multiple' => false]) ?>

  <?= Html::submitButton('Guardar cambios', ['class' => 'btn btn-success']) ?>
  <?php

  $form->end();
