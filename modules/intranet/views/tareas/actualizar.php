<?php
use yii\helpers\Html;

$this->title = 'Actualiza Tareas: ' . ' ' . $model->titulo;
?>
<div class="tareas-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

  </div>
