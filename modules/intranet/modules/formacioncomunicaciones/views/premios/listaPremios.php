<?php
  use yii\widgets\ListView;
  $this->title = 'Redime tus premios';
  use yii\helpers\Html;
  use yii\helpers\Url;
?>
<h3>Redime tus premios</h3>

<div class="row">
<?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/banner.png', ['class' => 'img-responsive']) ?>
  <div class="col-md-10">
      <p class="cantidad-puntos">Tus puntos: <span><?php echo $puntos?></span></p>
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
          'itemView' => function ($model, $var, $index, $widget) {
            return $this->render('_premio', ['model' => $model]);
          },
          'itemOptions' => [
            'tag' => false,
          ],
        ]);
      ?>
  </div>
</div>