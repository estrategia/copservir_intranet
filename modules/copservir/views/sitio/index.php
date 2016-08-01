<?php
use yii\helpers\Html;

$this->title = 'Copservir';

// Rutas imagenes
$srcSlide = Yii::$app->homeUrl . 'img/multiportal/copservir/';
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
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
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

    <div class="container marketing">
      <section>  <!-- acerca de home -->



      </section> <!-- / acerca de home -->
      </div>
      <div class="space-2"></div>
      <div class="container"> <!-- full section -->
          <div class="row">
             <div class="col-md-6">
                 <img class="img-responsive" src=<?= "" . $srcSlide . "parallax-home.jpg" ?> alt="">
             </div>
              <div class="col-md-6">
                  
                        <h2 style="color:#23B149;font-size: 38px;font-weight: bold;margin:0px;">Somos ejemplo de permanencia, fortaleza y consolidación.</h2>
                   
                    <div class="space-1"></div>
                    <p class="text-justify">Somos Copservir Ltda, una de las más importantes cooperativas del país. Desde hace más de 20 años comercializamos productos y servicios bajo la marca comercial La Rebaja Droguerías y Minimarkets.</p>
                    <p class="text-justify">Nuestra consolidación empresarial y cooperativa, se puede evidenciar en nuestra expansión por el territorio Colombiano, llegando a más de 170 municipios del País generando así más de 6.000 empleos 
                        directos, aportando al crecimiento y desarrollo de las diferentes regiones donde hacemos presencia con nuestros más de 800 puntos de venta, La rebaja Droguería.</p>
                    <div class="space-1"></div>
                  
              </div>
          </div>
      </div> <!-- / full section -->
  <!--      <div class="bg-parallax">
          <div class="container green-container">
          <div class="green-square">
            <h2>Aportamos a nuestra sociedad a través de la cooperación y el apoyo mutuo entre individuos para ofrecer a la comunidad servicios o artículos en las condiciones más beneficiosas</h2>
          </div>
          </div>
        </div>-->

      <div class="space-2"></div>
      <div class="space-2"></div>
      <div class="container marketing">
        <section> <!-- / counter section -->
          <div class="row">
            <div class="col-sm-3">
              <div class="counter-item">
                <span class="timer count-title" id="count-number" data-to="900" data-speed="1500"></span>
                <h3>Puntos de venta en el país</h3>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="counter-item">
                <span class="timer count-title" id="count-number" data-to="5580" data-speed="1500"></span>
                <h3>Empleados</h3>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="counter-item">
                <span class="timer count-title" id="count-number" data-to="117" data-speed="1500"></span>
                <h3>Ciudades atendidas</h3>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="counter-item">
                <span class="timer count-title" id="count-number" data-to="6000" data-speed="1500"></span>
                <h3>Clientes atendidos</h3>
              </div>
            </div>
          </div>
        </section> <!-- / counter section -->
      </div>
      <div class="space-2"></div>
      <!-- -->
      <?php
        echo $this->render('//common/_ultimasNoticias', [
          'contenidoModels' => $contenidoModels,
          'flagVerMas' => $flagVerMas,
        ]);
      ?>
      <div class="space-2"></div>
      <!-- ALIADOS -->
      <?= $this->render('//common/_portales', []) ?>
    <div class="space-1"></div>
      <!-- /ALIADOS -->
