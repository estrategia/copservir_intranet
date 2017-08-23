<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;
use kartik\rating\StarRating;

$this->title = 'Cursos';
$this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['curso/mis-cursos']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>Cursos</h1>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item_misContenidos',
    'pager' => [
        'prevPageLabel' => 'Anterior',
        'nextPageLabel' => 'Siguiente',
        'maxButtonCount' => 3,
    ],
]); ?>
