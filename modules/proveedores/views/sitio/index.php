<?php
use yii\helpers\Html;

$this->title = 'Proveedores';

// Rutas imagenes
$srcSlide = Yii::$app->homeUrl . 'img/multiportal/proveedores/';
?>

<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide banner-copservir" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
		<li data-target="#myCarousel" data-slide-to="4"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img class="img-responsive" src=<?= "" . $srcSlide . "banner-home.jpg" ?> alt="First slide">
                 <!--<div class="carousel-caption">
                     <img width="100" src="<?= "" . $srcSlide . "great-logo.png" ?>" alt="Great place to work">
                     <h3>Somos una de las mejores empresas para trabajar en Colombia</h3>                
                 </div>-->
        </div>
        <div class="item">
            <img class="img-responsive" src=<?= "" . $srcSlide . "banner-home1.jpg" ?> alt="First slide">
                 <!--<div class="carousel-caption">
                     <img width="100" src="<?= "" . $srcSlide . "great-logo.png" ?>" alt="Great place to work">
                     <h3>Somos una de las mejores empresas para trabajar en Colombia</h3>                
                 </div>-->
        </div>		
        <div class="item">
            <img class="img-responsive" src=<?= "" . $srcSlide . "banner-home2.jpg" ?> alt="Second slide">
                 <!--<div class="carousel-caption">
                     <h3>Generamos más de 6.000 empleos en Colombia</h3>                
                 </div>    -->           
        </div>
        <div class="item">
            <img class="img-responsive" src=<?= "" . $srcSlide . "banner-home3.jpg" ?> alt="Third slide">
                 <!--<div class="carousel-caption">
                     <h3>Hacemos presencia en más de 170 Municipios del país</h3>                
                 </div>    -->            
        </div>
        <div class="item">
            <img class="img-responsive" src=<?= "" . $srcSlide . "banner-home4.jpg" ?> alt="Third slide">
                 <!--<div class="carousel-caption">
                    <h3>Somos una de las 100 empresas más grandes del país</h3>                
                </div>   -->       
        </div> 
    </div>
</div>

<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container internal text-left">
  <section>  <!-- acerca de home -->
    <div class="acerca-home">
      <h1>Bienvenido a nuestra nuevo portal colaborativo</h1>
      <div class="space-1"></div>
      <p class="text-center">En el 2017 se presentarán nuevos retos los cuales requerirán de la colaboración y sinergia con nuestros proveedores, definiendo así el rumbo estratégico con confianza, responsabilidad y profesionalismo.</p>
      <div class="space-1"></div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="white-item">
          <div class="default-icon left-icon big-icon company-bgcolor-1"><span class="glyphicon glyphicon-file iconos-home"></span></div>
		  <a href="/proveedores/retencion"><h3>Descargar Certificados</h3></a>	  
		  <p>Información 2015.</p>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="white-item">
          <div class="default-icon left-icon big-icon company-bgcolor-1"><span class="glyphicon glyphicon-eye-open iconos-home"></span></div>
			<?php if(Yii::$app->user->isGuest): ?>
				<a href="/proveedores/sitio/contenido?menu=27"><h3>Paute con Nosotros</h3></a>	
				<p>¿Qué es Publireb?</p>
			<?php else:?>
				<a href="http://intranet2.copservir.com/control_publireb/listado/" target="_blank"><h3>Paute con Nosotros</h3></a>
				<p>Publireb espacios disponibles.</p>
			<?php endif; ?>  
        </div>
      </div>
      <div class="col-sm-4">
        <div class="white-item">        
			<?php if(Yii::$app->user->isGuest): ?>
				<div class="default-icon left-icon big-icon company-bgcolor-1"><span class="glyphicon glyphicon-link iconos-home"></span></div>
				<a href="/proveedores/vinculate"><h3>Relación Comercial</h3></a>	 
				<p>Convierte en proveedor.</p>
			<?php else:?>
				<div class="default-icon left-icon big-icon company-bgcolor-1"><span class="glyphicon glyphicon-bullhorn iconos-home"></span></div>
				<a href="/proveedores/calendario"><h3>Actividades Comerciales</h3></a>	 
				<p>Eventos, Promociones y Actividades.</p>
			<?php endif; ?>

        </div>
      </div>
    </div>
  </section> <!-- / acerca de home -->
</div>

<!-- -->
<?php
  if(Yii::$app->user->isGuest == false)
  {
	echo $this->render('//common/_ultimasNoticias', [
		'contenidoModels' => $contenidoModels,
		'flagVerMas' => true,
	]);	
  }
?>
<div class="space-2"></div>
<!-- ALIADOS -->
<?php //echo $this->render('//common/_portales', []) ?>
<div class="space-1"></div>
<!-- /ALIADOS -->
