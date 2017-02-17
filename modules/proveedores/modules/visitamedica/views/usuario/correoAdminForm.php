<?php
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Html;

$this->title = 'Contacto';
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
<div class="alert alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <strong>
      <?= Yii::$app->session->getFlash('success') ?>
    </strong>
</div>
<?php endif; ?>
<div class="container">
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <h3>Enviar correo al administrador</h3>
        </div>
    </div>
    <div class="panel-body">
        
        <?php $form = ActiveForm::begin(); ?>
      
            <?= $form->field($model, 'contenido')->widget(Widget::className(), [
              'settings' => [
                'replaceDivs' => false,
                'lang' => 'es',
                'minHeight' => 100,
              ]
            ])->label(false); ?>
          
            <div class="form-group">
                <?= Html::submitButton('Enviar Correo', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>