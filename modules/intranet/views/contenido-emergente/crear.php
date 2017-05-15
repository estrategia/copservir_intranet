<?php

use yii\helpers\Html;

$this->title = 'Crea un contenido emergente';
$this->params['breadcrumbs'][] = ['label' => 'Contenidos emergentes', 'url'=>['/intranet/contenido-emergente/admin']];
$this->params['breadcrumbs'][] = ['label' => "Crear"];
?>

<div class="contenido-emergente-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

  </div>
