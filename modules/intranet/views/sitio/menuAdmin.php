<?php
use app\modules\intranet\models\Menu;
use yii\helpers\Html;

$this->title = 'Administrar menú corporativo';
$this->params['breadcrumbs'][] = $this->title;
$opciones = Menu::construirArrayMenu(true,Yii::$app->user->identity->numeroDocumento);

?>
<div class="col-md-12" id="menu">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <button type="button" name="button" class="btn btn-success" data-role="opcion-menu-render-crear" >Crear opci&oacute;n del men&uacute;</button>
  </p>

  <?=   yii2mod\tree\Tree::widget([
    'items' => $opciones,
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
