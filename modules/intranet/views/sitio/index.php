<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
// importancion necesaria para el modal
use yii\bootstrap\Modal;

/* @var $this yii\web\View */

$this->title = 'Intranet - Copservir';
?>

<!-- begin UP BANNER -->
<div class="col-md-12">
    <div class="tiles overflow-hidden full-height tiles-overlay-hover m-b-10 widget-item">
        Banner
    </div>
</div>
<!-- END UP BANNER -->

<!-- begin PUBLICACIONES -->
<div class="col-md-9">

    <!-- nav lineas de tiempo -->
    <ul class="nav nav-tabs">
        <?php foreach ($lineasTiempo as $linea): ?>
            <li ><a id="#lt<?= $linea->idLineaTiempo ?>" data-toggle="tab" data-role="cambiar-timeline"  data-timeline="<?= $linea->idLineaTiempo ?>" href="#lt<?= $linea->idLineaTiempo ?>"><?= $linea->nombreLineaTiempo ?></a></li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active">
            <!-- el contenido de las lineas de tiempo -->
            <?php foreach ($lineasTiempo as $linea): ?>

                <div id="lt<?= $linea->idLineaTiempo ?>" class="tab-pane fade lineastiempo">
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6"><button class="btn btn-block btn-success" type="button">Ver Noticas Mercadeo</button></div>
        <div class="col-md-6"><button class="btn btn-block btn-warning" type="button">Ver Noticas Copservir</button></div>
    </div>
</div>
<!-- END PUBLICACIONES -->

<!--  BEGIN ESTADISTICAS -->
<div class="col-md-3">
    <!-- Estadisticas -->
    <div class="col-md-12 col-sm-12">

        <?php foreach ($indicadores as $indicador): ?>
            <?php echo $this->render('_indicador', ['indicador' => $indicador]); ?>
        <?php endforeach; ?>

    </div>

    <div class="col-md-12 col-sm-12">
        BANNER
    </div>
</div>

<!-- END ESTADISTICAS -->

<!-- begin OFERTAS LABORALES Y TAREAS -->
<?php echo $this->render('_ofertasLaborales',['ofertasLaborales' => $ofertasLaborales])?>

<div class="col-md-4">
    <br><br><br>
    <div class="col-md-12 col-sm-12 spacing-bottom">
        <div class="widget">
            <div class="widget-title dark">
                <div class="pull-left ">
                    <button class="btn  btn-dark  btn-small" type="button"><i class="fa fa-plus"></i></button>
                </div>
                Tareas
                <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
            </div>
            <div class="widget-body">
                <div class="col-md-12">
                    <input type="text" class="form-control dark m-b-25" id="date">
                </div>
                <br>
                <div class="row-fluid">
                    <div class="checkbox check-success 	">
                        <input type="checkbox" value="1" id="chk_todo01" class="todo-list">
                        <label for="chk_todo01" class="done">Enviar correo a Jaime para las firmas</label>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="checkbox check-success 	">
                        <input type="checkbox" checked="checked" value="1" id="chk_todo02" class="todo-list">
                        <label for="chk_todo02" class="done">Llamar a Martha!!</label>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="checkbox check-success 	">
                        <input type="checkbox" value="1" id="chk_todo03" class="todo-list">
                        <label for="chk_todo03" class="done">Actualizar las campañas ASAP</label>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="checkbox check-success 	">
                        <input type="checkbox" value="1" id="chk_todo04" class="todo-list">
                        <label for="chk_todo04">Hacer Backup</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END OFERTAS LABORALES Y TAREAS -->
<!-- begin DOWN BANNER -->
<div class="col-md-12">
    BANNER ..............
</div>


<!-- END DOWN BANNER -->
