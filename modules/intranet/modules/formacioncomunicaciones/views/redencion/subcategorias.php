<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<h3>Categorías de premios</h3>
<div class="row">
  <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/banner.png', ['class' => 'img-responsive']) ?>

  <div class="col-md-10">
    <?php foreach ($categoria->categoriasPremios as $categoria): ?>
      <div class="col-sm-4 col-md-4 item">
        <div class="sub-categoria-item">
         
            <div class="puntos">
              <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/puntos.png', ['class' => 'img-responsive']) ?> 
              <span class="quantity">15.000 <br> puntos</span>              
            </div>

            <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/categorias/'. $categoria->rutaIcono, ['class' => 'img-responsive']) ?>

            <h4 class="nombre-sub-categoria"><?= $categoria->nombreCategoria ?></h4>
          
          <a href="/">
          <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/redimir.png', ['class' => 'redimir']) ?>
          </a> 
        </div>
        
      </div>
    <?php endforeach ?>

  </div>




  </div>