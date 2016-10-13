<?php
use yii\helpers\Html;
use \yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
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

    <div class="form-group">
        <?= Html::submitButton('cargar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>