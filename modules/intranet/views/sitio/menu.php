<?php
use app\modules\intranet\models\Menu;


$opciones = Menu::construirArrayMenu(false,Yii::$app->user->identity->numeroDocumento);

echo yii2mod\tree\Tree::widget([
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
