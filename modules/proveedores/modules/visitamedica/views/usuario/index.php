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
<div class="row">
    <div class="col-md-12 ">
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
                            [
                                'attribute' => 'Estado',
                                'value' => 
                                    function ($model) {
                                        $estado = '';
                                        if ($model->objUsuario->estado == 1) {
                                            $estado = 'Activo';
                                        } else {
                                            $estado = 'Inactivo';
                                        }
                                        return $estado;
                                    },
                            ],
                            [
                                'attribute' => 'Nit Laboratorio',
                                'value' =>
                                    function ($model) {
                                        return $model->nitLaboratorio;
                                    },
                                'visible' => Yii::$app->user->identity->tienePermiso('proveedores_admin'),
                            ],
                            [
                                'attribute' => 'Nombre Laboratorio',
                                'value' =>
                                    function ($model) {
                                        return $model->nombreLaboratorio;
                                    },
                                'visible' => Yii::$app->user->identity->tienePermiso('proveedores_admin'),
                            ],
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
                            [
                                'attribute' => '',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $glyphicon = '';
                                    if ($model->objUsuario->estado == 1) {
                                            $glyphicon = 'glyphicon-remove';
                                    } else {
                                        $glyphicon = 'glyphicon-ok';
                                    }
                                    return '<a href="'. $url = 'cambiar-estado?id=' . $model->numeroDocumento .'"><span class="glyphicon '. $glyphicon .'" aria-hidden="true"></span></a>';
                                },
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
