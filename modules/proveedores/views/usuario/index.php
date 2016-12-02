<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\proveedores\models\UsuarioProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>
                  <?= Yii::$app->session->getFlash('error') ?>
                </strong>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>
                  <?= Yii::$app->session->getFlash('success') ?>
                </strong>
            </div>
        <?php endif; ?>

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
                            return '<a class="btn btn-default" href="'. Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/ver?id='. $model->numeroDocumento .'">Asignar permisos</a>';
                        },
                    ],
                    [
                        'attribute' => '',
                        'format' => 'raw',
                        'value' => function ($model) {                      
                            return '<a class="btn btn-default" href="'. Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/actualizar?id=' . $model->numeroDocumento .'">Editar</a>';
                        },
                    ],
                    [
                                'attribute' => '',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $clase = '';
                                    $texto = '';
                                    if ($model->objUsuario->estado == 1) {
                                        $clase = 'btn btn-danger';
                                        $texto = 'Desactivar';
                                    } else {
                                        $clase = 'btn btn-success';
                                        $texto = 'Activar';
                                    }
                                    return '<a class="'. $clase .'" href="'. $url = 'cambiar-estado?id=' . $model->numeroDocumento .'"> ' . $texto . ' </a>';
                                },
                            ],
                ],
            ]); ?>

        </div>
    </div>
</div>
