<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\proveedores\models\UsuarioProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestion de Usuarios';
$this->params['breadcrumbs'][] = $this->title;
// $urlBase = Yii::$app->getUrlManager()->getBaseUrl();
?>
<div class="container">
    <div class="row">
        <h1><?= Html::encode($this->title) ?> <small><?= Yii::$app->user->identity->objUsuarioProveedor->nombreLaboratorio ?></small></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p> 
            <?= Html::a('Crear Usuario', ['crear'], ['class' => 'btn btn-success']) ?>
        </p>
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
                    // 'nombreLaboratorio',
                    // 'idTercero',
                    // 'idFabricante',
                    // 'idAgrupacion',
                    // 'nombreUnidadNegocio',
                    [
                        'attribute' => '',
                        'format' => 'raw',
                        'value' => function ($model) {                      
                            return '<a href="'. Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/ver?id='. $model->numeroDocumento .'"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></a>';
                        },
                    ],
                    [
                        'attribute' => '',
                        'format' => 'raw',
                        'value' => function ($model) {                      
                            return '<a href="'. Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/actualizar?id=' . $model->numeroDocumento .'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
                        },
                    ],
                ],
            ]); ?>

        </div>
    </div>
</div>
