<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use bupy7\cropbox\Cropbox;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perfil de usuario'), 'url'=>['/intranet/usuario/perfil']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fotos de perfil')];

?>

<?php

$form = ActiveForm::begin([
  "method" => "post",
  "enableClientValidation" => true,
  "options" => ["enctype" => "multipart/form-data"],
]);
?>
<?php

echo $form->field($modelFoto, 'imagenPerfil')->widget(Cropbox::className(), [
  'attributeCropInfo' => 'crop_info',
  'pluginOptions' => [
    'variants' => [[
      'width' => 300,
      'height' => 300,
      'minWidth' => 300,
      'minHeight' => 300,
      'maxWidth' => 300,
      'maxHeight' => 300
      ]],
      ['width' => 300, 'height' => 300]
    ]
  ]);
  ?>
  
  <?= Html::submitButton('Guardar cambios', ['class' => 'btn btn-success']) ?>
  <?php

  $form->end();
