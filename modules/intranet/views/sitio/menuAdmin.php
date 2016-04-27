<?php

use app\modules\intranet\models\Menu;
use yii\helpers\Html;

$this->title = 'Administra menu corporativo';
$opciones = Menu::construirArrayMenu(true);
?>
<div class="col-md-12" id="menu">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <button type="button" name="button" class="btn btn-success" data-role="opcion-menu-render-crear" >Crear opcion del menu</button>
  </p>

  <?=   yii2mod\tree\Tree::widget([
              'items' => $opciones,
              'options' => [
                  'autoCollapse' => true,
                  'clickFolderMode' => 2,
                  'activate' => new \yii\web\JsExpression('
                          function(node, data) {
                                node  = data.node;
                                // Log node title
                                console.log(node.title);
                          }
                  ')
              ]
          ]);
  ?>
</div>