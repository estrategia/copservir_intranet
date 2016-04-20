<?php
use yii\helpers\Html;
?>

<div class="col-md-12" id="plantilla-documento">
  <h4>Titulo documento: <?= $model->titulo ?></h4>
  <p>
    Descripción: <?= $model->descripcion  ?>
  </p>
  <p>
      <?= Html::a('ver documento', $model->rutaDocumento, [
              'target' => '_blank',
          ]);
      ?>
  </p>
</div>
