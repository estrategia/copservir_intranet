<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buscar Cursos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buscador-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_buscador_form', 
        [
            'model' => $searchModel,
        ]); 
    ?>
    <br>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'buscador-container',
            'id' => 'list-wrapper',
        ],
        'layout' => "{pager}\n{items}\n{summary}",
        'itemView' => '_item_buscador',
        'pager' => [
            'nextPageLabel' => 'next',
            'prevPageLabel' => 'previous',
            'maxButtonCount' => 3,
        ],
    ]); ?>
</div>
