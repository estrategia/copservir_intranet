<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

// importancion necesaria para el modal
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

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

      <?= Html::a('<i class="fa fa-pencil"></i> Publicar <i><small>Requiere Aprobación</small></i>', '#', [
            'id' => 'show-publications',
            'class' => 'btn btn-primary btn-lg btn-large',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
            //'data-url' => Url::to(['guardarContenido']),
        ]); ?>


    <?php
        Modal::begin([
            'id' => 'modal',
            'header' => '<h4 class="modal-title">Complete</h4>',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
        ]);

        echo "<div class=''>hola</div>";

        Modal::end();
    ?>

      <!--<a data-toggle="modal" data-target="#modal_formulario_noticias" type="button" class="btn btn-primary btn-lg btn-large"> <i class="fa fa-pencil"></i> Publicar <i><small>Requiere Aprobación</small></i></a>-->

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
    <div class="tiles blue    m-b-10">
      <div class="tiles-body">
        <div class="controller">
          <a href="javascript:;" class="reload"></a>
          <a href="javascript:;" class="remove"></a>
        </div>
        <h4 class="text-black no-margin semi-bold">Productos</h4>
        <h2 class="text-white bold "><span data-animation-duration="900" data-value="24534" class="animate-number">24,534</span></h2>
        <div class="description">
          <i class="icon-custom-up"></i><span class="text-white mini-description ">&nbsp; 4% aumento  <span class="blend">en el mes</span></span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- END ESTADISTICAS -->

<!-- begin OFERTAS LABORALES Y TAREAS -->
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-title no-border">
                	<h4 style="color:#fff !important;">Ofertas <span class="semi-bold">Laborales</span></h4>
                <div class="tools">
                  <a href="javascript:;" class="collapse"></a>
        					<a href="#grid-config" data-toggle="modal" class="config"></a>
        					<a href="javascript:;" class="reload"></a>
        					<a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="grid-body no-border">
                    <p>La Oficina de Talento Humano tiene a disposició los siguientes ofertas.  Más información en la linea +571 33009845 o a <a href="rrhh@copservir.com">rrhh@copservir.com</a>
					</p>
                    <br>
                    <table class="table table-hover no-more-tables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Oferta</th>
                                <th>Ciudad</th>
                                <th>Fecha</th>
                                <th>Area</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>DEPENDIENTE CHIQUINQUIRA</td>
                                <td>Bogotá</td>
                                <td>16/01/2015</td>
                                <td>Telemercadeo</td>
                                <td><a href="http://clasificados.elempleo.com/Forms/view_jobOffer.aspx?jo=DEPENDIENTE-CHIQUINQUIRA-_1881720409" type="button" class="btn btn-primary btn-sm btn-small" target="_blank">Postularse</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Técnico Soporte (Nivel 2)</td>
                                <td>Cali</td>
                                <td>10/12/2015</td>
                                <td>Sistemas y Tecnología</td>
                                <td><a href="http://clasificados.elempleo.com/Forms/view_jobOffer.aspx?jo=DEPENDIENTE-CHIQUINQUIRA-_1881720409" type="button" class="btn btn-primary btn-sm btn-small" target="_blank">Postularse</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>ASESOR COMERCIAL EXTERNO </td>
                                <td>Medellín</td>
                                <td>10/12/2015</td>
                                <td>Comercial</td>

                                <td><a href="http://clasificados.elempleo.com/Forms/view_jobOffer.aspx?jo=DEPENDIENTE-CHIQUINQUIRA-_1881720409" type="button" class="btn btn-primary btn-sm btn-small" target="_blank">Postularse</a></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
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
      BANNER
  </div>


<!-- END DOWN BANNER -->

<?php
        $this->registerJs(
            " //aria-expanded='true'
            $( document ).ready(function() {
                //console.log($('nav-tabs:first-child')[0]) ;
                console.log($('#lt1')[0]);
                console.log($('.hola')[0])
            });


            $(document).on('click', '#activity-index-link', (function() {
                $.get(
                    $(this).data('url'),
                    function (data) {
                        $('.modal-body').html(data);
                        $('#modal').modal();
                    }
                );
            }));"
        );
    ?>
