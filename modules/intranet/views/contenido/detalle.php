<?php
$this->title = 'Detalle noticia: '. $noticia->titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<span id='contenido_<?= $noticia->idContenido ?>'>
  <?php
  echo $this->render('_contenido', ['noticia' => $noticia, 'completo'=>true]);
  ?>
</span>
