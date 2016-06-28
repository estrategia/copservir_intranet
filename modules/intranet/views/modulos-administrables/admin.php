<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('app', 'Modulos Contenidos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Módulos Administrativos')];
?>

<div class="">
    <?= Html::a(Yii::t('app', 'Crear Modulo'), ['crear'], ['class' => 'btn btn-primary']) ?>
    <div class="space-1"></div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'tipo',
                'format' => 'text',
                'label' => 'tipo',
                'content' => function($data) {
                    return Yii::$app->params['modulosContenido'][$data->tipo];
                },
                'filter' => Html::dropDownList("ModuloContenido[tipo]", null, Yii::$app->params['modulosContenido'], ['class' => 'form-control', 'prompt' => 'Seleccione'])
            ],
            'titulo',
            'descripcion',
            //'fechaRegistro',
            [
                'label' => 'URL',
                'format' => 'text',
                'filter' => false,
                'content' => function($data){
                    return Yii::$app->params['rutaGruposModulos'].$data->idModulo;
                }
            ],
            [
                'attribute' => 'contenido',
                'label' => 'Contenido',
                'format' => 'text',
                'filter' => '',
                'content' => function($data) {
                    return Html::a('Visualizar', '#', ['data-role' => 'ver-contenido-administrable', 'data-contenido' => $data->contenido]);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{actualizar} {eliminar}',
                'buttons' => [
                    'actualizar' => function ($url, $model) {
                      return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    },
                    'eliminar' => function ($url, $model) {
                      return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                    }
                ],
            ],  
        ],
        'options' => [
            'class' => 'table-responsive'
        ]
    ]);
?>

</div>
