<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\OfertasLaborales;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */

$this->title = 'detalle oferta';
$this->params['breadcrumbs'][] = ['label' => 'Ofertas laborales', 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => 'Ver oferta laboral'];
?>
<div class="ofertas-laborales-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idOfertaLaboral], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idOfertaLaboral], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Estas seguro de eliminar esta oferta laboral?',
        'method' => 'post',
      ],
      ]) ?>
    </p>

    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        'tituloOferta',
        'descripcionContactoOferta:ntext',
        [
          'attribute' => 'estado',
          'value' =>  $model->estado == OfertasLaborales::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
        ],
        [
          'attribute' => 'idCiudad',
          'value' => $model->objCiudad->nombreCiudad,
        ],
        [
          'attribute' => 'nombreCargo',
          'value' => $model->nombreCargo,
        ],
        'idArea',
        'urlElEmpleo:url',
        'fechaPublicacion',
        'fechaCierre',
        'fechaInicioPublicacion',
        'fechaFinPublicacion',
        [
          'attribute' => 'idInformacionContacto',
          'format'=>'raw',
          'value' =>  $model->objInformacionContactoOferta->plantillaContactoHtml,
        ],

      ],
      ]) ?>

    </div>
