<?php
$this->title = 'Detalle Noticia';
?>

<div class="space-2"></div>
<div class="space-2"></div>


<div class="container internal text-left">
  <section>
      <div class="white-item">
        <h1><?= $contenidoModel->titulo ?></h1>
        <div style="max-height: 90px; text-overflow:ellipsis; white-space:pre-line; overflow:hidden;">
          <?= $contenidoModel->contenido ?>
        </div>
      </div>
  </section>
</div>

<div class="space-2"></div>
<div class="space-2"></div>
