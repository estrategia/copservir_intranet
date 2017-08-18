<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremiosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contenidos realizados';
$this->params['breadcrumbs'][] = 'Reportes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reportes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => '',
                'label' => 'Contenido',
                'value' => 'contenido.tituloContenido',
                'filter' => Html::activeInput('text', $searchModel, 'tituloContenido', ['class' => 'form-control']),
            ],
            [
                'attribute' => '',
                'label' => 'Curso',
                'value' => 'curso.nombreCurso',
                'filter' => Html::activeInput('text', $searchModel, 'nombreCurso', ['class' => 'form-control']),
            ],
            'numeroDocumento',
            [
                'attribute' => '',
                'label' => 'Nombres',
                'value' => 'usuarioIntranet.nombres',
                'filter' => Html::activeInput('text', $searchModel, 'nombres', ['class' => 'form-control']),
            ],
            [
                'attribute' => '',
                'label' => 'Primer Apellido',
                'value' => 'usuarioIntranet.primerApellido',
                'filter' => Html::activeInput('text', $searchModel, 'primerApellido', ['class' => 'form-control']),
            ],
            [
                'attribute' => '',
                'label' => 'Segundo Apellido',
                'value' => 'usuarioIntranet.segundoApellido',
                'filter' => Html::activeInput('text', $searchModel, 'segundoApellido', ['class' => 'form-control']),
            ],
            [
                'attribute' => '',
                'label' => 'Proveedor',
                'value' => 'contenido.nombreProveedor',
                'filter' => Html::activeInput('text', $searchModel, 'nombreProveedor', ['class' => 'form-control']),
            ]
            // 'tiempoLectura',
            // 'fechaCreacion',
        ],
    ]); ?>
</div>
