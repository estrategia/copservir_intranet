<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
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
                'options' => [
                    'tag' => 'div',
                    'class' => 'list-wrapper',
                    'id' => 'list-wrapper',
                ],
                'layout' => "{summary}\n{items}\n<div class='col-md-4 col-md-offset-8'>{pager}</div>",
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