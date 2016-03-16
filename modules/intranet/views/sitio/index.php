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
        <?= $this->render('banner',['banners'=>$bannerArriba, 'location' =>0])?>
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

      <?php foreach($indicadores as $indicador):?>
            <?php echo $this->render('_indicador',['indicador' => $indicador]);?>
      <?php endforeach;?>

  </div>

  <!--publicidad derecha -->
  <div class="col-md-12 col-sm-12">


    <div id="myCarousel" class="carousel slide vertical">
          <!-- Carousel items -->
          <div class="carousel-inner">
            <?php $contador = 0 ?>
            <?php foreach ($bannerDerecha as $banner): ?>
              <div  id="bannerDerecha<?= $contador  ?>" class="item">
                  <img src="<?= Yii::$app->homeUrl . 'img/campanas/'.$banner['rutaImagen'] ?>" alt="...">
              </div>
              <?php  $contador++; ?>
            <?php endforeach; ?>

          </div>

      </div>


  </div>
</div>

<!-- END ESTADISTICAS -->

<!-- begin OFERTAS LABORALES Y TAREAS -->
<?php echo $this->render('_ofertasLaborales',['ofertasLaborales' => $ofertasLaborales])?>

<div class="col-md-4" id="widget-tareas">
  <?php echo $this->render('/tareas/_tareasHome',['tareasUsuario' => $tareasUsuario])?>
</div>

<!-- END OFERTAS LABORALES Y TAREAS -->
<!-- BEGIN DOWN BANNER -->
<div class="col-md-12">
  <?= $this->render('banner',['banners'=>$bannerAbajo, 'location' =>1])?>
</div>

<!-- END DOWN BANNER -->

<?php

  $this->registerJs(
  "
  //::::::::::::::::::::::
  // POPUP INDEX
  //::::::::::::::::::::::

  /*
  * Ajax que trae la informacion del modal 
  */
  $( document ).ready(function() {

      $.ajax({
          type: 'GET',
          async: true,
          url: requestUrl + '/intranet/sitio/popup-contenido',
          dataType: 'json',
          beforeSend: function() {
          //    Loading.show();
          $('#widget-popup').remove();
          },

          complete: function(data) {
           //   Loading.hide();
          },
          success: function(data) {
              if (data.result == 'ok') {


                  $('body').append(data.response);
                  $('#widget-popup').modal('show');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
      })

      //::::::::::::::::::::::
      // CAMPAÑAS
      //::::::::::::::::::::::

      // indica cuales son las primeras imagenes en los banner (sliders) de publicidad
      $('#bannerArriba0').attr('class', 'item active');
      $('#bannerDerecha0').attr('class', 'item active');
      $('#bannerAbajo0').attr('class', 'item active');

      // para que se desplace el banner vertical
      $('#myCarousel').carousel({
        interval: 5000
      })
  });

  "
  );



 ?>
