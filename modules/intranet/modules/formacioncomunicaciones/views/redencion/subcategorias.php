<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="categorias-premios-redencion-container">
    <?php foreach ($categoria->categoriasPremios as $categoria): ?>
      <div class="categoria-premios-redencion-item">
        <a href="<?= Url::to(['redencion/premios-categoria', 'idCategoria' => $categoria->idCategoria]) ?>">
          <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/categorias/'. $categoria->rutaIcono, ['class' => 'img-responsive thumbnail']) ?>
          <h4>
            <?= $categoria->nombreCategoria ?>
          </h4>
        </a>
      </div>
    <?php endforeach ?>
  </div>