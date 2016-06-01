<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use vova07\imperavi\Widget;
use app\modules\intranet\models\ModuloContenido;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\TipoPQRS */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-pqrs-form">
    <input type='hidden' value='<?= $model->idModulo ?>' id='idGrupo' name='idGrupo'/>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'tipo')->dropDownList(Yii::$app->params['modulosContenido'], ['prompt' => 'Seleccione...',]) ?>
    <?php else: ?>
        <?= $form->field($model, 'tipo')->dropDownList(Yii::$app->params['modulosContenido'], ['prompt' => 'Seleccione...', 'disabled' => ('disabled')]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

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

    <?php if ($model->tipo == ModuloContenido::TIPO_GROUP_MODULES): ?>

        <h3>Agregar Módulos</h3>
        <?=
        GridView::widget([
            'dataProvider' => $dataProviderNoAgregados,
            'columns' => [
                'titulo',
                'tipo',
                'descripcion',
                //    'contenido',
                [
                    //    'attribute' => 'IdOrigenCaso',
                    'label' => 'Opción',
                    'format' => 'text',
                    'content' => function($data, $model) {
                        return Html::a('Agregar', '#', ['data-role' => 'agregar-modulo', 'data-modulo' => $data->idModulo]);
                    },
                        ],
//                [
//                    'class' => 'yii\grid\ActionColumn',
//                    'template' => '{update} {delete}'
//                ],
                    ],
                    'options' => [
                        'class' => 'table-responsive'
                    ]
                ]);
                ?>
                <h3>Módulos Agregados</h3>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProviderAgregados,
                    'id' => 'tabla_agregados',
                    'columns' => [
                        'titulo',
                        'tipo',
                        'descripcion',
                        // 'contenido',
                        [
                            'label' => 'Orden',
                            'format' => 'text',
                            'content' => function($data) use ($model) {
                                $modulo = app\modules\intranet\models\GruposModulos::find()->where(['and', ['idGruposModulos' => $model->idModulo], ['idModulo' => $data->idModulo]])->one();
                                return "<input type='number' id='orden_$data->idModulo' class='input-xs' value='$modulo->orden'>";
                            },
                        ],
                        [

                            'label' => 'Opciones',
                            'format' => 'text',
                            'content' => function($data) {
                                return "<a href='#' title='Actualizar' data-role='editar-modulo' data-modulo='$data->idModulo'> <span class='glyphicon glyphicon-pencil'></span></a> &nbsp;
                                        <a href='#' title='Eliminar' data-role='eliminar-modulo' data-modulo='$data->idModulo'> <span class='glyphicon glyphicon-trash'></span></a>                       <br/>
                                        ";
                            },
                        ],
//                        [
//                            'class' => 'yii\grid\ActionColumn',
//                        //   'template' => '{update} {delete}'
//                        ],
                    ],
                    'options' => [
                        'class' => 'table-responsive'
                    ]
                ]);
                ?>
            <?php endif; ?>


</div>
