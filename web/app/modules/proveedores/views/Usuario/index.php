<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\proveedores\models\UsuarioProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuario Proveedors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-proveedor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Usuario Proveedor', ['create'], ['class' => 'btn btn-success']) ?>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
