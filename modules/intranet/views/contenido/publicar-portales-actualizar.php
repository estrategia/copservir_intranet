<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Actualizar noticia de portal';
$this->params['breadcrumbs'][] = ['label' => 'Noticias de portales', 'url' => ['/intranet/sitio/publicar-portales']];
$this->params['breadcrumbs'][] = ['label' => 'Actualizar noticia'];
?>

<div class="col-md-12">
  <h3><?= Html::encode($this->title) ?></h3>
  <br>
  <div class="formulario">
    <?=
      $this->render('/contenido/_formPublicarPortales', [
                  'contenidoModel' => $contenidoModel,
                  'esAdmin' => $esAdmin,
      ]);
    ?>
  </div>
</div>
