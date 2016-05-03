<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Administrar categorias documento';
?>

<div class="col-md-12" id="menu-categoria-documento">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <button type="button" name="button" class="btn btn-success" data-role="categoria-crear" >Crear categoria</button>
  </p>

  <!-- MENU -->
  <div data-toggle="collapse" id="accordion" class="panel-group">
    <?= $menu ?>
  </div>
</div>
