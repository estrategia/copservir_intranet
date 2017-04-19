<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use app\modules\intranet\modules\formacioncomunicaciones\models\Curso;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<div class="cuestionario-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'tituloCuestionario')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcionCuestionario')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'porcentajeMinimo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'numeroPreguntas')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'numeroIntentos')->textInput(['maxlength' => true]) ?>
    <?php
    echo \vova07\imperavi\Widget::widget([
        'selector' => '#cuestionario-descripcioncuestionario',
        'settings' => [
            'replaceDivs' => false,
            'lang' => 'es',
            'minHeight' => 80,
            'imageUpload' => Url::toRoute('cuestionario/cargar-imagen'),
            'fileUpload' => Url::toRoute('cuestionario/cargar-archivo'),
            'plugins' => [
                'imagemanager',
            ],
            'fileManagerJson' => Url::to(['sitio/files-get']),
        ]
    ]);
    ?>
	<?php $cursos = Curso::findAll(['estadoCurso' => Curso::ESTADO_ACTIVO]);?>
    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>
    <?php echo $form->field($model, 'idCurso')->widget(Select2::classname(), [
          'data' => ArrayHelper::map($cursos, 'idCurso','nombreCurso'),
          'options' => ['placeholder' => 'Selecione ...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
        ]);?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>