<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */

$this->title = 'Activacion de cuenta';
?>

<div class="container">
  <div class="space-2"></div>
  <div class="space-2"></div>
  <div class="row">
    <div class="col-md-12">

      <h2><?= Html::encode($this->title) ?></h2>

      <div class="space-1"></div>

      <?= $this->render('/common/errores', []) ?>
    </div>
  </div>
  <div class="space-2"></div>
  <div class="space-2"></div>
</div>
