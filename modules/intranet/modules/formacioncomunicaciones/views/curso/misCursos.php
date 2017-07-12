<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;
use kartik\rating\StarRating;

$this->title = 'Programas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
  <h1>
    Programas
  </h1>
    <!-- <a href="<?= Url::to('recomendados') ?>" class="btn btn-default">Recomendados <span class="glyphicon glyphicon-star"></span></a> -->
    <!-- <a href="<?= Url::to('leidos') ?>" class="btn btn-default">Terminados <span class="glyphicon glyphicon-ok-circle"></span></a> -->
</div>
<br>
<div class="row">
    <div class="col-md-6">
        <?= ListView::widget([
            'dataProvider' => $dataProviderObligatorios,
            'itemView' => '_item_misCursos',
            'pager' => [
                'prevPageLabel' => 'Anterior',
                'nextPageLabel' => 'Siguiente',
                'maxButtonCount' => 3,
            ],
        ]); ?>
    </div>
    <div class="col-md-6">
        <?= ListView::widget([
            'dataProvider' => $dataProviderOpcionales,
            'itemView' => '_item_misCursos',
            'pager' => [
                'prevPageLabel' => 'Anterior',
                'nextPageLabel' => 'Siguiente',
                'maxButtonCount' => 3,
            ],
        ]); ?>
    </div>
</div>