<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = $model->numeroDocumento;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Proveedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-proveedor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->numeroDocumento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->numeroDocumento], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numeroDocumento',
            'nombre',
            'primerApellido',
            'segundoApellido',
            'email:email',
            'telefono',
            'celular',
            'nitLaboratorio',
            'profesion',
            'fechaNacimiento',
            'Ciudad',
            'Direccion',
            'nombreLaboratorio',
            'idTercero',
            'idFabricante',
            'idAgrupacion',
            'nombreUnidadNegocio',
        ],
    ]) ?>

</div>
