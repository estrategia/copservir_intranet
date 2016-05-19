<?php

use yii\helpers\Html;

?>

<div class="col-sm-12 left-line">
  <div class="item">
    <i></i>
    <h2><?= $modelContenido->titulo ?></h2>
    <div style="max-height: 90px; text-overflow:ellipsis; white-space:pre-line; overflow:hidden;">
      <?= $modelContenido->contenido ?>
    </div>
  </div>
  <div class="item item-last">
    <?=
      Html::a('Leer más',
        ['detalle-noticia','idNoticia' => $modelContenido->idContenido], ['class' => 'company-color-2'])
    ?>
  </div>
</div>
