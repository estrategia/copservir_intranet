<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<h1>Categorías de premios</h1>
<div class="row">

<?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/banner.png', ['class' => 'img-responsive']) ?>
<div class="col-md-10">
  <?php foreach ($categorias as $categoria): ?>
    <div class="col-sm-4 col-md-4 item">
    <div class="categoria-item">
      <h4 class="nombre-categoria"><?= $categoria->nombreCategoria ?></h4>
      <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/categorias/'. $categoria->rutaIcono, ['class' => 'img-responsive ']) ?>  
       <div class="sub-cat">
          <a href="<?= Url::to(['redencion/subcategorias', 'idCategoria' => $categoria->idCategoria]) ?>">
            <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/mas.png', ['class' => 'more']) ?>
          </a>
       </div> 
    </div>
    
    </div>
  <?php endforeach ?>
</div>
</div>
