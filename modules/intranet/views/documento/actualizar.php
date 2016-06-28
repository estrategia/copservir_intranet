<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Documento */

$this->title = 'Actualizar el Documento: ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Documentos organizacionales', 'url' => ['/intranet/documento/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Actualizar documento'];
?>
<div class="documento-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

  </div>
