<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\InformacionContactoOferta;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\InformacionContactoOferta */

$this->title = $model->nombrePlantilla;
//$this->params['breadcrumbs'][] = ['label' => 'Informacion Contacto Ofertas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacion-contacto-oferta-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idInformacionContacto], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idInformacionContacto], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'estas seguro de eliminar esta plantilla?',
        'method' => 'post',
      ],
      ]) ?>
    </p>

    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [

        'nombrePlantilla',
        'plantillaContactoHtml:ntext',
        [
          'attribute' => 'estado',
          'value' =>  $model->estado == InformacionContactoOferta::PLANTILLA_ACTIVA ? 'Activo' : 'Inactivo',
        ],
        'fechaRegistro',
      ],
      ]) ?>

    </div>
