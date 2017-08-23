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
<?php $mes = strtoupper(date('n')); ?>
<?php $meses = [
    1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO',
    7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'
] ?>

<div class="indicadores-container">
    <div class="indicador">
        <a href=<?= Url::toRoute('reportes/ranking-usuarios') ?> >
            <div class="tiles blue text-center ">
            <?php if ($indicadores['ranking'] != null): ?>
                    <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['ranking'] ?></h2>
                    <div class="tiles-title text-white blend p-b-25"> DE <?php echo $indicadores['usuariosTotales']?> USUARIOS<br>RANKING NACIONAL </div>
                    <div class="clearfix"></div>
            <?php else: ?>
                <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10">N/A</h2>
                <div class="tiles-title text-white blend p-b-25">ESTE MES NO HAS REALIZADO CURSOS</div>
                <div class="clearfix"></div>    
            <?php endif ?>
            </div>
        </a>
    </div>
    <div class="indicador">
        <a href=<?= Url::toRoute('contenido/pendientes-usuario') ?> >
            <div class="tiles red text-center ">
                <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['cursosPendientes'] ?></h2>
                <div class="tiles-title text-white blend p-b-25">CURSOS PENDIENTES ASIGNADOS</div>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
    <div class="indicador">
        <div class="tiles green text-center ">
            <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['cursosHechos'] ?></h2>
            <div class="tiles-title text-white blend p-b-25">CURSOS REALIZADOS <br>&nbsp;</div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="indicador">
        <a href="<?= Url::toRoute('contenido/pendientes-recientes') ?>" >
            <div class="tiles black text-center ">
                <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['cursosNuevos'] ?></h2>
                <div class="tiles-title text-white blend p-b-25">CURSOS NUEVOS <br> <?php echo $meses[$mes] ?> </div>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
    <div class="indicador">
        <a href="<?= Url::toRoute('contenido/recomendados') ?>" >
            <div class="tiles red text-center ">
                <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['cursosNuevosDisponibles'] ?></h2>
                <div class="tiles-title text-white blend p-b-25">CURSOS NUEVOS DISPONIBLES</div>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
    <div class="indicador">
        <div class="tiles purple text-center ">
            <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['puntosObtenidos'] == null ?  0 : $indicadores['puntosObtenidos'] ?></h2>
            <div class="tiles-title text-white blend p-b-25">PUNTOS OBTENIDOS <?php echo $meses[$mes] ?></div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="indicador">
        <a href="<?= Url::toRoute('reportes/mis-puntos') ?>" >
            <div class="tiles black text-center ">
                <h2 class="semi-bold text-white text-primary weather-widget-big-text no-margin p-t-35 p-b-10"><?php echo $indicadores['puntosTotales'] ?></h2>
                <div class="tiles-title text-white blend p-b-25">PUNTOS OBTENIDOS TOTALES</div>
                <div class="clearfix"></div>
            </div>
        </a>
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
    