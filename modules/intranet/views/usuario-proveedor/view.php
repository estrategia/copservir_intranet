<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = $model->nombre . ' ' . $model->primerApellido;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Proveedor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->numeroDocumento], ['class' => 'btn btn-primary']) ?>
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
</div>
