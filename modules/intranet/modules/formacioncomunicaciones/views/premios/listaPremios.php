<?php
  use yii\widgets\ListView;
  $this->title = 'Redime tus premios';
  use yii\helpers\Html;
  use yii\helpers\Url;
?>
<h3>Redime tus premios</h3>

<div class="row">
<?= $this->render('/banners/banner', ['banner' => $banner])  ?>
  <div class="col-md-10">
      <h2 class="cantidad-puntos">Tus puntos: <span><?php echo $puntos?></span></h2>
      <?=
        ListView::widget([
          'dataProvider' => $listDataProvider,
          'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
          ],
          'pager' => [
            'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],  
          ],
          'layout' => "{summary}\n{items}\n<center>{pager}</center>",
          'itemView' => '_premio',
          'viewParams' => ['restriccion' => $restriccion],
          'itemOptions' => [
            'tag' => false,
          ],
        ]);
      ?>
  </div>
</div>