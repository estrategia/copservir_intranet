<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
?>

<div class="col-md-1 "></div>
<div class="col-md-10">
    <div class="tiles white m-b-10">
        <div class="tiles-body">
            <div class="tiles-title"> NOTIFICACIONES </div>
            <br>
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
        </div>
    </div>
</div>