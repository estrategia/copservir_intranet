<?php
  $this->title = 'Categorías de premios';
  use yii\helpers\Html;
  use yii\helpers\Url;
use yii\base\Controller;
?>
<h3>Categorías de premios</h3>
<div class="row">
<?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/banner.png', ['class' => 'img-responsive']) ?>
<div class="col-md-10">
  <?php foreach ($categoria->categoriasPremios as $categoria): ?>
    <div class="col-sm-3 col-md-3 item">
    <a href="<?php echo Url::to(['premios/ver-premios', 'idCategoria' => $categoria->idCategoria])?>">
      <div class="categoria-item">
        <h4 class="nombre-categoria"><?= $categoria->nombreCategoria ?></h4>
        <?= Html::img(Yii::getAlias('@web'). Yii::$app->params['formacioncomunicaciones']['rutaImagenCategorias']. $categoria->rutaIcono, ['class' => 'img-responsive']) ?>
        
        <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/mas.png', ['class' => 'more']) ?>  
      </div>
    </a>

    </div>
  <?php endforeach ?>
  </div>
</div>