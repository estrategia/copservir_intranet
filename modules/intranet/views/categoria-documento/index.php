<?php
/* @var $this yii\web\View */
$this->title = 'Menú de documentos organizacionales';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menú documentos organizacionales')];
?>
<h1><?=$this->title?></h1>

<!-- MENU -->
<div data-toggle="collapse" id="accordion" class="panel-group">
  <?= $menu ?>
</div>

<!--
<div class="cf nestable-lists">
  <div class="dd-nodrag" id="nestable">
  </div>
</div>
-->
