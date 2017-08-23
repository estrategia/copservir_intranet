<?php use yii\widgets\ListView; ?>
<?= ListView::widget([
        'dataProvider' => $dataProviderCalificacion,
        'options' => [
            'tag' => 'div',
            'class' => 'buscador-container',
            'id' => 'list-wrapper',
        ],
        'layout' => "{pager}\n{items}",
        'itemView' => '_item_calificacion',
        'pager' => [
            'nextPageLabel' => 'next',
            'prevPageLabel' => 'previous',
            'maxButtonCount' => 3,
        ],
    ]); ?>