<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\ContenidoEmergente */

$this->title = 'Actualiza el Contenido Emergente: ';
//$this->params['breadcrumbs'][] = ['label' => 'Contenido Emergentes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->idContenidoEmergente, 'url' => ['view', 'id' => $model->idContenidoEmergente]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contenido-emergente-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    'destinoContenidoEmergente' => $destinoContenidoEmergente,
    'modelDestinoContenidoEmergente' => $modelDestinoContenidoEmergente
    ]) ?>

  </div>
