<?php

use yii\helpers\Html;

$this->title = 'Intranet - Copservir';
?>

<!-- begin UP BANNER -->
<?php if(!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_BANNER_SUP,Yii::$app->user->identity->getOcultosDashboard())): ?>
  <div class="col-md-12">
    <div class="tiles overflow-hidden full-height tiles-overlay-hover m-b-10 widget-item">
      <?= $this->render('banner', ['banners' => $bannerArriba, 'location' => 0]) ?>
    </div>
  </div>
<?php endif;?>
<!-- END UP BANNER -->
<!-- BEGIN CUMPLEAÑOS -->
<!--
<?php if(!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_CUMPLEANOS ,Yii::$app->user->identity->getOcultosDashboard())): ?>
<div class="col-md-12">
  <div class="grid simple">

    <div class="grid-title no-border">

      <div class="tools">
        <a href="javascript:;" data-role="quitar-elemento"
        data-elemento="<?=\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_CUMPLEANOS ?> "  class="remove"></a>
      </div>

       <ul class="nav nav-tabs" role="tablist">
         <li role="presentation" class="active"><a href="#cumpleanos" aria-controls="home" role="tab" data-toggle="tab">Cumpleaños</a></li>
         <li role="presentation"><a href="#aniversarios" aria-controls="profile" role="tab" data-toggle="tab">Aniversarios</a></li>
       </ul>

    </div>
    <div class="grid-body no-border">

        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="cumpleanos">
            <div class="col-md-12">
              <?php if(!empty($cumpleanos)): ?>
                <?= $this->render('/cumpleanos/_carouselCumpleanos', ['flag'=>'Cumpleaños', 'models'=>$cumpleanos]) ?>
              <?php endif;?>
            </div>

            <div class="col-md-12">
              <?=
                Html::a('Ver todos',  ['todos-cumpleanos'], [
                  'class' => 'btn btn-primary btn-lg btn-block',
                ]);
              ?>
            </div>

          </div>
          <div role="tabpanel" class="tab-pane" id="aniversarios">
            <div class="col-md-12">
              <?php if(!empty($aniversarios)): ?>
                <?=  $this->render('/cumpleanos/_carouselCumpleanos', ['flag'=>'Aniversarios', 'models'=>$aniversarios]) ?>
              <?php endif;?>
            </div>

            <div class="col-md-12">
              <?=
                Html::a('Ver todos',  ['todos-aniversarios'], [
                  'class' => 'btn btn-primary btn-lg btn-block',
                ]);
              ?>
            </div>

          </div>
        </div>

    </div>
  </div>
</div>
<?php endif;?>
-->
<!-- END CUMPLEAÑOS -->

<!-- begin PUBLICACIONES -->
<div class="col-md-9">

  <!-- nav lineas de tiempo -->
  <ul class="nav nav-tabs timeline">
    <?php $i = 0; ?>
    <?php foreach ($lineasTiempo as $linea): ?>
      <li <?= $i == 0 ? 'class="active"' : '' ?> style="background-color:<?= $linea->color ?>;">
        <a id="#lt<?= $linea->idLineaTiempo ?>" data-toggle="tab" data-role="cambiar-timeline"  data-timeline="<?= $linea->idLineaTiempo ?>" href="#lt<?= $linea->idLineaTiempo ?>">
          <span class="<?= $linea->icono ?>" aria-hidden="true"></span>
          <?= $linea->nombreLineaTiempo ?>
        </a>
      </li>
      <?php if ($i == 0): ?>
        <?php
        $this->registerJs(
        "  $( document ).ready(function() {
          cambiarTimeline('$linea->idLineaTiempo', '#lt$linea->idLineaTiempo')
        }); "
      );
      ?>
    <?php endif; ?>
    <?php $i++; ?>
  <?php endforeach; ?>
</ul>

<div class="tab-content">
  <div class="tab-pane active">
    <!-- el contenido de las lineas de tiempo -->
    <?php $i = 0; ?>
    <?php foreach ($lineasTiempo as $linea): ?>
      <div id="lt<?= $linea->idLineaTiempo ?>" class="tab-pane fade lineastiempo <?= $i == 0 ? 'in active' : '' ?>">

      </div>

      <?php $i++; ?>
    <?php endforeach; ?>

  </div>
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

  <!--publicidad derecha -->
  <div class="col-md-12 col-sm-12">


    <div id="myCarousel" class="carousel slide vertical">
      <!-- Carousel items -->
      <div class="carousel-inner">
        <?php $contador = 0 ?>
        <?php foreach ($bannerDerecha as $banner): ?>
          <div  id="bannerDerecha<?= $contador ?>" class="item">
            <img src="<?= Yii::$app->homeUrl . 'img/campanas/' . $banner['rutaImagen'] ?>" alt="...">
          </div>
          <?php $contador++; ?>
        <?php endforeach; ?>

      </div>

    </div>


  </div>
</div>

<!-- END ESTADISTICAS -->

<!-- begin OFERTAS LABORALES Y TAREAS -->
<?php if (!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_OFERTAS, Yii::$app->user->identity->getOcultosDashboard())): ?>
  <?php //echo $this->render('_ofertasLaborales', ['ofertasLaborales' => $ofertasLaborales]) ?>
<?php endif; ?>


<?php if (!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_TAREAS, Yii::$app->user->identity->getOcultosDashboard())): ?>
  <div class="col-md-4" id="widget-tareas">
    <?php //echo $this->render('/tareas/_tareasHome', ['tareasUsuario' => $tareasUsuario]) ?>
  </div>
<?php endif; ?>

<!-- END OFERTAS LABORALES Y TAREAS -->

<!-- BEGIN DOWN BANNER -->
<?php if(!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_BANNER_INF,Yii::$app->user->identity->getOcultosDashboard())): ?>
  <div class="col-md-12">
    <?= $this->render('banner', ['banners' => $bannerAbajo, 'location' => 1]) ?>
  </div>
<?php endif;?>
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
    url: requestUrl + '/intranet/contenido-emergente/contenido-emergente-html',
    dataType: 'json',
    beforeSend: function() {
      //    Loading.show();
      $('#widget-popup').remove();
    },

    complete: function(data) {
      //   Loading.hide();
    },
    success: function(data) {
      console.log('succes')
      if (data.result == 'ok') {
        console.log(data.response.length);
        if(data.response.length >0){
          $('body').append(data.response);
          $('#widget-popup').modal('show');
        }

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
