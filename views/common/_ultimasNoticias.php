<?php

use yii\helpers\Html;

?>
<section class="gray-sec">
  <div class="container marketing">
  <h2>Últimas noticias</h2>
  <div class="row">
    <?php foreach ($contenidoModels as $noticia): ?>
      <div class="col-sm-6 right-line">
        <div class="item">
        <i></i>
        <!--<img src="http://placehold.it/60x80" alt="">-->
        <h2><?= $noticia->titulo ?></h2>
        <div id="contenido-noticia" style="max-height: 90px; text-overflow:ellipsis; white-space:pre-line; overflow:hidden;">
          <?= $noticia->contenido ?>
        </div>


        </div>
        <div class="item item-last">
        <?=
        Html::a('Leer más',
          ['detalle-noticia','idNoticia' => $noticia->idContenido, 'nombrePortal'=>Yii::$app->controller->module->id], ['class' => 'company-color-2'])
        ?>

        </div>
      </div>
    <?php endforeach; ?>

    <?php if ($numeroNoticias > 4): ?> <!-- cambiar por un parametro  -->
      <div class="space-2"></div>
      <div class="space-2"></div>
        <?=
          Html::a('Ver más', 'ver-todos-portal', ['class' => 'btn-primary company-bgcolor-2']);
        ?>
      </div>
    <?php endif; ?>

</section>
