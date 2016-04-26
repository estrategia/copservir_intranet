<?php
use yii\helpers\Html;
?>
<hr>
<div class="" id="plantilla-documento">
  <h4>Titulo documento: <?= $model->titulo ?></h4>
  <p>
    Descripción: <?= $model->descripcion  ?>
  </p>
  <p>
      <?= Html::a('ver documento', Yii::getAlias('@web') . Yii::$app->params['documentos']['rutaArchivo'] .$model->rutaDocumento, [
              'target' => '_blank',
          ]);
      ?>
  </p>
</div>
