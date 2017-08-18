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
    <?= $this->render('/banners/banner', ['banner' => $banner]) ?>
    <!-- <a href="<?= Url::to('recomendados') ?>" class="btn btn-default">Recomendados <span class="glyphicon glyphicon-star"></span></a> -->
    <!-- <a href="<?= Url::to('leidos') ?>" class="btn btn-default">Terminados <span class="glyphicon glyphicon-ok-circle"></span></a> -->
</div>
<br>

<div class="row">
    <div class="col-md-2">
        <div class="tiles blue text-center m-b-10">
            <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['ranking'] ?></h2>
            <div class="tiles-title text-white blend p-b-25">RANKING NACIONAL</div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="tiles red text-center m-b-10">
            <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['cursosPendientes'] ?></h2>
            <div class="tiles-title text-white blend p-b-25">CURSOS PENDIENTES</div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="tiles green text-center m-b-10">
            <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['cursosHechos'] ?></h2>
            <div class="tiles-title text-white blend p-b-25">CURSOS REALIZADOS</div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="tiles black text-center m-b-10">
            <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['puntosObtenidos'] ?></h2>
            <div class="tiles-title text-white blend p-b-25">PUNTOS OBTENIDOS</div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="tiles purple text-center m-b-10">
            <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['cursosNuevos'] ?></h2>
            <div class="tiles-title text-white blend p-b-25">CURSOS NUEVOS</div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

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
    