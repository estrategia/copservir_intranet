<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;
use kartik\rating\StarRating;

$this->title = 'Mis Cursos Recientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
  <h2>
    Mis cursos recientes
  </h2>
    <a href="<?= Url::to('recomendados') ?>" class="btn btn-default">Recomendados <span class="glyphicon glyphicon-star"></span></a>
    <a href="<?= Url::to('leidos') ?>" class="btn btn-default">Terminados <span class="glyphicon glyphicon-ok-circle"></span></a>
</div>
<br>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item_misCursos',
    'pager' => [
        'firstPageLabel' => 'first',
        'lastPageLabel' => 'last',
        'prevPageLabel' => 'previous',
        'nextPageLabel' => 'next',
        'maxButtonCount' => 3,
    ],
]); ?>