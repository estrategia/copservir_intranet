<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\trademarketing\models\AsignacionPuntoVenta;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\AsignacionPuntoVenta */

$this->title = 'Detalle asignacion';
//$this->params['breadcrumbs'][] = ['label' => 'Asignacion Punto Ventas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="space-1"></div>
<div class="space-2"></div>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('calificar', ['calificar', 'id' => $model->idAsignacion], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idAsignacion',
            //'idComercial',
            'NombrePuntoDeVenta',
            'nombreTipoNegocio',
            'ciudad.nombreCiudad',
            //'idZona',
            'nombreZona',
            //'idSede',
            'nombreSede',
            //'numeroDocumento',
            // [
            //   'label' => 'Administrador del punto de venta',
            //   'attribute' => 'usuarioAdministrador.alias',
            // ],
            'numeroDocumentoAdministradorPuntoVenta',
            'numeroDocumentosubAdministradorpuntoVenta',
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == AsignacionPuntoVenta::ESTADO_INACTIVO ? 'Inactivo' : $model->estado == AsignacionPuntoVenta::ESTADO_PENDIENTE ? 'Pendiente' : 'Calificada',
            ],
            'fechaAsignacion',
        ],
    ]) ?>

</div>

<div class="space-1"></div>
<div class="space-2"></div>
