<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\CursoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis redenciones';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mis-reedenciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'Icon',
                'format' => 'html',
                'label' => '',
                'value' => function ($data) {
                return Html::img(\Yii::getAlias('@web') . \Yii::$app->params['formacioncomunicaciones']['rutaImagenPremios'] . $data->objPremio->rutaImagen,
                   ['width' => '60px']);
                },
            ],

            [
                'attribute' => 'Premio',
                'format' => 'raw',
                'value' => 'objPremio.nombrePremio',
                'filter' => Html::activeTextInput($searchModel, 'nombrePremio')
            ],
            
            [
                'attribute' => 'estado',
                'value'  => function ($model)
                {
                    if ($model->estado == 1) {
                        return 'Pendiente';
                    } elseif ($model->estado == 2) {
                        return 'Tramitado';
                    } elseif ($model->estado == 3) {
                        return 'Cancelado';
                    }
                },
                'filter'=>array('1' => 'Pendiente', '2' => 'Tramitado', '3' => 'Cancelado'),
            ],
            'fechaCreacion',
            'fechaEntrega',
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle} {traza}',
              'buttons' => [
                'detalle' => function ($url, $model) {
                  return  Html::a('<span><span class="glyphicon glyphicon-eye-open"></span>Detalle</span>', $url);
                },
                'traza' => function ($url, $model) {
                  return  Html::a('<span><span class="glyphicon glyphicon-list-alt"></span>Historial</span>', '#', ['data-role'=> 'ver-traza', 'data-id-redencion' => $model->idUsuarioPremio]);
                }
              ],
            ],
        ],
    ]); ?>
</div>
