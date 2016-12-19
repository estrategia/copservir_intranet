<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\proveedores\models\UsuarioProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestion de Usuarios';
$this->params['breadcrumbs'][] = $this->title;
$urlBase = Yii::$app->getUrlManager()->getBaseUrl();
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p> 
                    <?= Html::a('Crear Usuario', ['crear'], ['class' => 'btn btn-success']) ?>
                    <a class="btn btn-default" href=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/intranet/usuario-proveedor/exportar-usuarios' ?> ">Exportar Usuarios</a>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pager' => [
                      'maxButtonCount' => 5,    // Set maximum number of page buttons that can be displayed
                    ],
                    'layout' => "{summary}\n{items}\n<center>{pager}</center>",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'numeroDocumento',
                        'nombre',
                        'primerApellido',
                        'email:email',
                        'nitLaboratorio',
                        'nombreLaboratorio',
                        [
                            'label' => 'Rol',
                            'attribute' => 'rol',
                            'value' => 'rol',
                        ],
                        [
                            'attribute' => '',
                            'format' => 'raw',
                            'value' => function ($model) {                      
                                return '<a href="'. Yii::$app->getUrlManager()->getBaseUrl() . '/intranet/usuario-proveedor/ver?id='. $model->numeroDocumento .'"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></a>';
                            },
                        ],
                        [
                            'attribute' => '',
                            'format' => 'raw',
                            'value' => function ($model) {                      
                                return '<a href="'. Yii::$app->getUrlManager()->getBaseUrl() . '/intranet/usuario-proveedor/actualizar?id=' . $model->numeroDocumento .'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                            },
                        ],
                        [
                            'attribute' => '',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a('Asignar permisos', Yii::$app->getUrlManager()->getBaseUrl() .'/intranet/permisos/usuario?id='. $model->numeroDocumento);
                            }
                        ]
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
