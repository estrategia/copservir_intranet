<?php
use yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>

<?php
//$this->title = Yii::t('app', 'Actualizar  ', []);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Módulos Administrativos'),'url' => ['admin']];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Editar')];
?>

<?= $this->render('/common/errores', []) ?>

<div class="documento-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'archivo')->fileInput(); ?>

    <?= 
      $form->field($model, 'mes')->widget(Select2::classname(), [
          'data' => Yii::$app->params['calendario']['meses'],
          'language' => 'es',
          'options' => ['placeholder' => 'Selecciona un mes...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
      ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('cargar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>