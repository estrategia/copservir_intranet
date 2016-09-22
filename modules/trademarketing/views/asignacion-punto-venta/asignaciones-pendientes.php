<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trademarketing\models\AsignacionPuntoVentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Puntos de venta asignados';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idAsignacion',
            //'idComercial',
            'NombrePuntoDeVenta',
            //'nombreTipoNegocio',
            'ciudad.nombreCiudad',
            // 'idZona',
            'nombreZona',
            //'idSede',
            'nombreSede',
            // 'numeroDocumento',
            // 'numeroDocumentoAdministradorPuntoVenta',
            // 'numeroDocumentosubAdministradorpuntoVenta',
            //'estado',

            [
              'attribute' => 'fechaAsignacion',
              'value' => 'fechaAsignacion',
              'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'fechaAsignacion',
                            'options' => ['placeholder' => 'Enter birth date ...'],
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd'
                            ]
                          ])

            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle}',
              'buttons' => [
                'detalle' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                }
              ],
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{calificar}',
              'buttons' => [
                'calificar' => function ($url, $model) {
                  return  Html::a('calificar', $url);
                }
              ],
            ],
        ],
    ]); ?>
</div>
