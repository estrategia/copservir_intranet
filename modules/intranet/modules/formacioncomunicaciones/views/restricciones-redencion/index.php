<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restricciones de Redención';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-info" role="alert">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<div class="restricciones-redencion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= $this->render('_formCargue', ['model' => $modeloCargue]) ?>
    
    <p>
        <?= Html::a('Crear Restricción de Redención', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'numeroDocumento',
            // 'fechaCreacion',
            [
                'attribute' => '',
                'label' => 'Nombres',
                'value' => 'objUsuarioIntranet.nombres',
                'filter' => Html::activeInput('text', $searchModel, 'nombres'),
            ],
            [
                'attribute' => '',
                'label' => 'Primer Apellido',
                'value' => 'objUsuarioIntranet.primerApellido',
                'filter' => Html::activeInput('text', $searchModel, 'primerApellido'),
            ],
            [
                'attribute' => '',
                'label' => 'Segundo Apellido',
                'value' => 'objUsuarioIntranet.segundoApellido',
                'filter' => Html::activeInput('text', $searchModel, 'segundoApellido'),
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{eliminar}',
              'buttons' => [
                'eliminar' => function ($url, $model) {
                  return  Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>', 
                        ['eliminar', 'id' => $model->numeroDocumento],
                        [
                            'class' => '',
                            'data' => [
                                'confirm' => 'Esta seguro de eliminar este item?',
                                'method' => 'POST',
                            ]
                        ]
                    );
                },
              ],
            ],
        ],
    ]); ?>
</div>
