<?php
use yii\widgets\ListView;
?>

<?=
ListView::widget([
  'dataProvider' => $listDataProvider,
  'options' => [
    'tag' => 'div',
    'class' => 'list-wrapper',
    'id' => 'list-wrapper',
  ],
  'pager' => [
    'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
  ],
  'layout' => "{summary}\n{items}\n<center>{pager}</center>",
  'itemView' => function ($model, $var, $index, $widget) {
    return $this->render('_contenido', ['noticia' => $model]);
  },
  'itemOptions' => [
    'tag' => false,
  ],
]);
?>
