<?php

use yii\helpers\Html;

$this->title = 'Intranet - Copservir';

$userCedula = Yii::$app->user->identity->numeroDocumento;
$rutaArchivo = Yii::getAlias('@webroot') . "/emisora/cedula_vendedores.csv";
$separador = ",";
$array_lrv = array();
$existe = false;
if(($handle = fopen("$rutaArchivo", "r")) !== false)
{
	while(($datos = fgetcsv($handle, 0, $separador)) !== false){
		$array_lrv[$datos[0]] = $datos;
		if(trim($datos[0]) == $userCedula){
			$existe=true;
			break;
		}
	}
	fclose($handle);
}
?>

<!-- begin UP BANNER -->
<?php if(!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_BANNER_SUP,Yii::$app->user->identity->getOcultosDashboard())): ?>
  <div class="col-md-12">
    <div class="overflow-hidden full-height tiles-overlay-hover m-b-10 widget-item">
	  <?php if($existe): ?>
		<?= $this->render('banner', ['banners' => $bannerArribaTwo, 'location' => 0]) ?>
	  <?php else:?>
	    <?= $this->render('banner', ['banners' => $bannerArriba, 'location' => 0]) ?>
	  <?php endif; ?>	
    </div>
  </div>
<?php endif;?>
<!-- END UP BANNER -->
<!-- BEGIN CUMPLEAÑOS -->

<?php if(!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_CUMPLEANOS ,Yii::$app->user->identity->getOcultosDashboard())): ?>
<div class="col-md-12">
    <div class="grid simple" style="margin-bottom:0px">

    <div class="grid-title no-border">

      <div class="tools" style="margin: 8px !important">
        <a href="javascript:;" data-role="quitar-elemento"
        data-elemento="<?=\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_CUMPLEANOS ?>" class="remove"></a>
      </div>

       <ul class="nav nav-tabs" role="tablist">
         <li role="presentation" class="active"><a href="#cumpleanos" aria-controls="home" role="tab" data-toggle="tab">Cumpleaños</a></li>
         <li role="presentation"><a href="#aniversarios" aria-controls="profile" role="tab" data-toggle="tab">Aniversarios</a></li>
       </ul>

    </div>
        <div class="grid-body no-border" style="padding: 0px">

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="cumpleanos" style="padding: 0">
            <div class="col-md-12">
              <?php if(!empty($cumpleanos)): ?>
                <?= $this->render('/cumpleanos/_carouselCumpleanos', ['flag'=>'Cumpleaños', 'models'=>$cumpleanos]) ?>
              <?php endif;?>
            </div>

            <div class="col-md-12">
              <?=
                Html::a('Ver todos',  ['todos-cumpleanos'], ['class' => 'btn btn-primary btn-lg btn-block btn-sm btn-small']);
              ?>
            </div>

          </div>
            <div role="tabpanel" class="tab-pane" id="aniversarios" style="padding:0">
            <div class="col-md-12">
              <?php if(!empty($aniversarios)): ?>
                <?=  $this->render('/cumpleanos/_carouselCumpleanos', ['flag'=>'Aniversarios', 'models'=>$aniversarios]) ?>
              <?php endif;?>
            </div>

            <div class="col-md-12">
              <?=
                Html::a('Ver todos',  ['todos-aniversarios'], ['class' => 'btn btn-primary btn-lg btn-block btn-sm btn-small']);
              ?>
            </div>

          </div>
        </div>

    </div>
  </div>
</div>
<?php endif;?>

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
  <div class="">
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
  
  <div class="col-md-12 col-sm-12">		   
	<?php
	//cantidad clientes
	$ac2=$a2/5;
	$bc2=$b2/4.5;
	$cc2=$c2/3.9;
	$dc2=$d2/3;

	$suma_clientes2=$ac2+$bc2+$cc2+$dc2;//suma cantidad clientes
	$suma_ponderado2=$a2+$b2+$c2+$d2;//suma ponderado
	$calificacion2= floor(($suma_ponderado2/$suma_clientes2)*pow(10, 1))/pow(10,1);//calificacion resultado final
	?>			
		<div id="indicador_3"> 
			<div class="tiles_lrv m-b-10">
				<div class="tiles-body">				
					<div class="row">
						<div class="col-xs-3"><img src="../../../archivos_intranet/caritas/logo_icono.png" width="45"></div>
						<div class="col-xs-9"><h4 class="text-black no-margin semi-bold">Experiencia Compra LRV</h4></div>
					</div>
					<h1 class="semi-bold text-white"><?= $calificacion2 ?> 
						<?php if ($calificacion2 <= 3): ?>
							<?= "<i class='icon-custom-down icon-custom-2x'></i>" ?>
						<?php else:?>
							<?= "<i class='icon-custom-up icon-custom-2x'></i>" ?>
						<?php endif; ?>
					</h1>
					<div class="description">
						<span class="text-white mini-description">Encuestas: <?= $suma_clientes2 ?></span>
					</div>
					<button class="btn btn-white btn-xs btn-mini" type="button" onclick="window.open('http://intranet2.copservir.com/intranet/docs/calificacion.php?mostrar=1', '_blank')">Más indicadores</button>
				</div>
			</div>
	    </div>				
  </div>
<!-- END ESTADISTICAS --> 

<!--publicidad derecha -->
  <?php //if(!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_BANNER_INF,Yii::$app->user->identity->getOcultosDashboard())): ?>

    <div class="col-md-12">
        <div class="overflow-hidden full-height tiles-overlay-hover m-b-10 widget-item">
          <?= $this->render('banner', ['banners' => $bannerDerecha, 'location' => 2]) ?>
        </div>

    </div>
 <?php //endif;?>
</div>

<!-- begin OFERTAS LABORALES Y TAREAS -->
<?php if (!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_OFERTAS, Yii::$app->user->identity->getOcultosDashboard())): ?>
  <?php echo $this->render('_ofertasLaborales', ['ofertasLaborales' => $ofertasLaborales]) ?>
<?php endif; ?>


<?php if (!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_TAREAS, Yii::$app->user->identity->getOcultosDashboard())): ?>
  <div class="col-md-4" id="widget-tareas">
    <?php echo $this->render('/tareas/_tareasHome', ['tareasUsuario' => $tareasUsuario]) ?>
  </div>
<?php endif; ?>

<!-- END OFERTAS LABORALES Y TAREAS -->

<!-- BEGIN DOWN BANNER -->
<?php if(!in_array(\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_BANNER_INF,Yii::$app->user->identity->getOcultosDashboard())): ?>
  <div class="col-md-12" style="margin-bottom:25px;">
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
      $('#widget-popup').remove();
    },

    complete: function(data) {
    },
    success: function(data) {
      if (data.result == 'ok') {
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
  $('#bannerLateral0').attr('class', 'item active');
  $('#bannerAbajo0').attr('class', 'item active');
});

"
);
?>
