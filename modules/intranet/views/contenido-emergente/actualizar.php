<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\ContenidoEmergente */

$this->title = 'Actualiza contenido emergente';
$this->params['breadcrumbs'][] = ['label' => 'Contenidos emergentes', 'url'=>['/intranet/contenido-emergente/admin']];
$this->params['breadcrumbs'][] = ['label' => "Actualizar #$model->idContenidoEmergente"];
?>
<div class="contenido-emergente-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    'destinoContenidoEmergente' => $destinoContenidoEmergente,
    'modelDestinoContenidoEmergente' => $modelDestinoContenidoEmergente
    ]) ?>

  </div>
