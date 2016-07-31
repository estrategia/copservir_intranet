<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>
<input type='hidden' value='<?= $model->idModulo ?>' id='idGrupo' name='idGrupo'/>

<h3>Agregar Módulos</h3>
<?=
GridView::widget([
    'dataProvider' => $dataProviderNoAgregados,
    'filterModel' => $searchModelAgregar,
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
        ['attribute' => 'titulo',
        ],
        'descripcion',
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
            'label' => 'Opción',
            'format' => 'text',
            'content' => function($data, $model) {
                return Html::a('Agregar', '#', ['data-role' => 'agregar-modulo', 'data-modulo' => $data->idModulo]);
            },
        ],
    ],
    'options' => [
        'class' => 'table-responsive'
    ]
])?>

<h3>Módulos Agregados</h3>
<?=
GridView::widget([
    'dataProvider' => $dataProviderAgregados,
    'id' => 'tabla_agregados',
    'columns' => [
        [
            'attribute' => 'tipo',
            'format' => 'text',
            'label' => 'tipo',
            'content' => function($data) {
                return Yii::$app->params['modulosContenido'][$data->tipo];
            }
        ],
        'titulo',
        'descripcion',
        [
            'attribute' => 'contenido',
            'label' => 'Contenido',
            'format' => 'text',
            'content' => function($data) {
                return Html::a('Visualizar', '#', ['data-role' => 'ver-contenido-administrable', 'data-contenido' => $data->contenido]);
            },
        ],
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
                return "<a href='#' title='Actualizar' data-role='editar-modulo' data-modulo='$data->idModulo'> <span class='glyphicon glyphicon-floppy-disk'></span></a> &nbsp;
        <a href='#' title='Eliminar' data-role='eliminar-modulo' data-modulo='$data->idModulo'> <span class='glyphicon glyphicon-trash'></span></a>                       <br/>
        ";
            },
        ],
    ],
    'options' => [
        'class' => 'table-responsive'
    ]
]);?>
