<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use app\modules\intranet\models\ModuloContenido;
use yii\grid\GridView;
?>
<input type='hidden' value='<?= $model->idModulo ?>' id='idGrupo' name='idGrupo'/>
<?php if ($model->tipo != ModuloContenido::TIPO_GROUP_MODULES): ?>
    <?php $form = ActiveForm::begin(); ?>
    <input type='hidden' value='<?= $model->idModulo ?>' id='idGrupo' name='idGrupo'/>
    <?php
    echo $form->field($model, 'contenido')->widget(Widget::className(), [
        'id' => "ModuloContenido_contenido",
        'settings' => [
            'lang' => 'es',
            'minHeight' => 100,
            //  'buttons' => ['format', 'bold', 'italic'],
            //'imageUpload' => Url::toRoute('sitio/cargar-imagen'),
            'fileUpload' => Url::toRoute('sitio/cargar-archivo'),
            'plugins' => [
                //'imagemanager',
                'fullscreen'
            ],
            'fileManagerJson' => Url::to(['sitio/files-get']),
        ]
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>