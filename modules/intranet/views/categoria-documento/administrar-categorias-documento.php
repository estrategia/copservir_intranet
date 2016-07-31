<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Administrar menú de documentos';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menú documentos organizacionales')];
?>

<div class="col-md-12" id="menu-categoria-documento">
  <h1><?= Html::encode($this->title) ?></h1>
  <p>
    <button type="button" name="button" class="btn btn-success" data-role="categoria-crear" >Crear categoria</button>
  </p>

  <div data-toggle="collapse" id="accordion" class="panel-group">
    <?= $menu ?>
  </div>
</div>
