<?php
$this->title = 'Detalle contenidoModel';
?>

<div class="container internal text-left">
  <section>
      <div class="white-item">
        <h1><?= $contenidoModel->titulo ?></h1>
        <div>
          <?= $contenidoModel->contenido ?>

          <!-- IMAGENES -->

          <?php if (!empty($contenidoModel->objContenidoAdjuntoImagenes)): ?>

              <?php $contador = 0; ?>
              <?php foreach ($contenidoModel->objContenidoAdjuntoImagenes as $imagenes): ?>
                  <?php
                  $contador++;
                  $style = '';
                  $mensaje = '';
                  if ($contador > \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) { //cambiar por una constante
                      $style = 'display:none';
                  }

                  if ($contador == \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) { //cambiar por una constante
                      if (($contador) != count($contenidoModel->objContenidoAdjuntoImagenes)) {
                          $mensaje = (count($contenidoModel->objContenidoAdjuntoImagenes) - \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) . '+'; // cambiar por una constante
                      }
                  }
                  ?>

                  <a class="lightbox gallery<?= $contenidoModel->idContenido ?>" href="<?= Yii::getAlias('@web') . "/img/imagenesContenidos/" . $imagenes->rutaArchivo ?>" style="<?= $style ?>">
                      <div class="col-md-6  col-sm-6" data-aspect-ratio="true">
                          <div class="slide-front ha slide">
                              <div class="overlayer bottom-left fullwidth">
                                  <div class="overlayer-wrapper">
                                      <div class="p-l-20 p-r-20 p-b-20 p-t-20" style="text-align:center;">
                                          <h1 style="color:#fff !important;"><span class="semi-bold"><?= $mensaje ?></span></h1>
                                      </div>
                                  </div>
                              </div>
                              <img src="<?= Yii::getAlias('@web') . "/img/imagenesContenidos/" . $imagenes->rutaArchivo ?>" class="img-thumbnail" />
                          </div>
                      </div>
                  </a>

              <?php endforeach; ?>
              <?php $this->registerJs("jQuery('.gallery$contenidoModel->idContenido').lightbox();");?>
              <script type="text/javascript">
                  jQuery('.lightbox').lightbox();
              </script>
          <?php endif; ?>

        </div>
      </div>
  </section>
</div>

<div class="space-2"></div>
<div class="space-2"></div>
