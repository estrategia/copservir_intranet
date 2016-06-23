<?php

//use vova07\imperavi\Widget;
//use yii\widgets\ActiveForm;
//use yii\helpers\Url;
//use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
?>
<?=
ListView::widget([
  'dataProvider' => $listDataProvider,
  'options' => [
    'tag' => 'div',
    'class' => 'list-wrapper',
    'id' => 'list-wrapper',
  ],
  'layout' => "{summary}\n{items}\n<div class='col-md-4 col-md-offset-8'>{pager}</div>",
  'itemView' => function ($model, $var, $index, $widget) {
    return $this->render('_contenido', ['noticia' => $model]);
  },
  'itemOptions' => [
    'tag' => false,
  ],
]);
?>
