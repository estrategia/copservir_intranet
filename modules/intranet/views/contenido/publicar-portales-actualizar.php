<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Actualiza una publicacion de un portal';
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
