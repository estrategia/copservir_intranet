<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\proveedores\modules\visitamedica\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['/proveedores/visitamedica/usuario/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>  
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?= Html::encode($this->title) ?></h3>
                </div>
            </div>
            <div class="panel-body">
                <p>
                    <?= Html::a('Crear Usuario', ['crear'], ['class' => 'btn btn-success']) ?>
                    <a class="btn btn-default" href=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/visitamedica/usuario/exportar-usuarios' ?> ">Exportar Usuarios</a>
                </p>
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'numeroDocumento',
                            'nombre',
                            'primerApellido',
                            'segundoApellido',
                            'email:email',
                            // 'telefono',
                            // 'celular',
                            // 'nitLaboratorio',
                            // 'profesion',
                            // 'fechaNacimiento',
                            // 'Ciudad',
                            // 'Direccion',
                            [
                                'attribute' => '',
                                'format' => 'raw',
                                'value' => function ($model) {                      
                                    return '<a href="'. $url = 'ver?id='. $model->numeroDocumento .'"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></a>';
                                },
                            ],
                            [
                                'attribute' => '',
                                'format' => 'raw',
                                'value' => function ($model) {                      
                                    return '<a href="'. $url = 'actualizar?id=' . $model->numeroDocumento .'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                                },
                            ],

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
