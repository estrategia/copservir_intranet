<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\Documento;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\DocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear un documento', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idDocumento',
            'titulo',
            'descripcion',
            [
                'label'=>'Descargar',
                'attribute' => 'rutaDocumento',
                'format'=>'raw',
                'value' => function($model) {
                  return Html::a('<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>', [$model->rutaDocumento], []);
                }
            ],
            [
  		        'attribute' => 'estado',
  		        'value' => function($model) {
                if ($model->estado == Documento::ESTADO_ACTIVO ) {
                  return 'Activo';
                }else{
                  return 'Inactivo';
                }
  			         }
			       ],
            // 'fechaCreacion',
            // 'fechaActualizacion',

            //['class' => 'yii\grid\ActionColumn'],
            [
             'class' => 'yii\grid\ActionColumn',
             'headerOptions'=> ['style'=>'width: 70px;'],
             'template' => '{detalle} {actualizar} {eliminar}',
             'buttons' => [
                 'detalle' => function ($url, $model) {
                     return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                 },
                 'actualizar' => function ($url, $model) {
                     return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                 },
                 'eliminar' => function ($url, $model) {
                     return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                 }
             ],
           ],

        ],
    ]); ?>
</div>
