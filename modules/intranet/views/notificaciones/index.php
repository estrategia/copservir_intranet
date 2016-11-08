<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-1 "></div>
<div class="col-md-10">
  <div class="tiles white m-b-10">
    <div class="tiles-body">
      <div class="tiles-title"> NOTIFICACIONES </div>
      <br>
      <?php Pjax::begin(['id'=> 'pjax-notificaciones', 'enablePushState'=>false]); ?>
      <?=
      ListView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
          'maxButtonCount' => 5,    // Set maximum number of page buttons that can be displayed
        ],
        'options' => [
          'tag' => 'div',
          'class' => 'list-wrapper',
          'id' => 'list-wrapper',
        ],
        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
        'itemView' => function ($model, $var, $index, $widget) {
          return $this->render('_notificacionItem', ['objNotificacion' => $model, 'idx' => $index]);
        },
        'itemOptions' => [
          'tag' => false,
        ],
      ]);
      ?>
      <?php Pjax::end(); ?>
    </div>
  </div>
</div>
