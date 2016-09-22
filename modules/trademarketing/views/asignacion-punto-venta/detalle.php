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

<div class="">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php if ($model->estado === AsignacionPuntoVenta::ESTADO_CALIFICADO): ?>
      <p>
          <?= Html::a('ver Reporte', ['reporte', 'id' => $model->idAsignacion], ['class' => 'btn btn-primary']) ?>
      </p>
    <?php else: ?>
      <?php if ($model->estado === AsignacionPuntoVenta::ESTADO_PENDIENTE): ?>
        <p>
            <?= Html::a('calificar', ['calificar', 'id' => $model->idAsignacion], ['class' => 'btn btn-primary']) ?>
        </p>
      <?php endif; ?>
    <?php endif; ?>


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
