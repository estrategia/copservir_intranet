<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Administrar menú de documentos organizacionales';
$this->params['breadcrumbs'][] = $this->title
?>

<div class="col-md-12" id="menu-categoria-documento">
  <h1><?= Html::encode($this->title) ?></h1>
  <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
      <?= Yii::$app->session->getFlash('success'); ?>
    </div>
  <?php endif ?>
  <p>
    <button type="button" name="button" class="btn btn-success" data-role="categoria-crear" >Crear categoria</button>
  </p>

<?php
  echo yii2mod\tree\Tree::widget([
    'items' => $menu,
    'options' => [
      'autoCollapse' => true,
      'clickFolderMode' => 2,
      'activate' => new \yii\web\JsExpression('
      function(node, data) {
        node  = data.node;
      }
      ')
    ]
  ]);
?>

</div>
