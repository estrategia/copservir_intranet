<?php

use yii\helpers\Html;

?>
<section class="gray-sec">
  <div class="container marketing">
  <h2>Últimas noticias</h2>
  <div class="row">
    <?php $separador ?>
    <?php foreach ($contenidoModels as $indice => $noticia): ?>

      <?php if (($indice + 1) % 2): ?>
        <?php $separador= 'right-line' ?>
      <?php else: ?>
        <?php $separador= '' ?>
      <?php endif; ?>

      <div class="col-sm-6 <?= $separador ?>">
        <div class="item">
          <i></i>
          <h2><?= $noticia->titulo ?></h2>
          <div style="max-height: 90px; text-overflow:ellipsis; white-space:pre-line; overflow:hidden;">
            <?= $noticia->contenido ?>
          </div>
        </div>
        <div class="item item-last">
          <?=
            Html::a('Leer más',
              ['detalle-noticia','idNoticia' => $noticia->idContenido], ['class' => 'company-color-2'])
          ?>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if ($flagVerMas): ?> <!-- cambiar por un parametro  -->
      <div class="space-2"></div>
      <div class="space-2"></div>
        <?=
          Html::a('Ver más', ['ver-todas-noticias'], ['class' => 'btn-primary company-bgcolor-2']);
        ?>
      </div>
    <?php endif; ?>

</section>
