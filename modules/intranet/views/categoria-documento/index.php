<?php
/* @var $this yii\web\View */
$this->title = 'Menú de documentos organizacionales';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menú documentos organizacionales')];
?>
<h1><?=$this->title?></h1>

<div class="just-padding" id="menu">
  <div class="list-group list-group-root well">
      <?php echo $menu ?>
  </div>

</div>
