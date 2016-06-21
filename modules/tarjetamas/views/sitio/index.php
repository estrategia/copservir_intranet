<?php
use yii\helpers\Html;

$this->title = 'Tarjeta Mas';

// Rutas imagenes
$srctarjetamas = Yii::$app->homeUrl . 'img/multiportal/tarjetamas';
?>
      <div id="slide-tarjetamas" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
              <li data-target="#slide-tarjetamas" data-slide-to="0" class=""></li>
              <li class="" data-target="#slide-tarjetamas" data-slide-to="1"></li>
              <li class="active" data-target="#slide-tarjetamas" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
              <div class="item">
                  <img class="first-slide" src="<?= "" . $srctarjetamas . "/banner1.jpg"?>" alt="First slide">
              </div>
              <div class="item">
                  <img class="second-slide" src="<?= "" . $srctarjetamas . "/banner2.jpg"?>" alt="Second slide">
              </div>
              <div class="item active">
                  <img class="third-slide" src="<?= "" . $srctarjetamas . "/banner3.jpg"?>" alt="Third slide">

              </div>
          </div>
          <a class="left carousel-control" href="#slide-tarjetamas" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#slide-tarjetamas" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
          </a>
      </div>

<div class="container internal text-left">
  <section>  <!-- acerca de home -->
    <div class="acerca-home">
      <h1>Tarjeta Más</h1>
      <div class="space-2"></div>
      
      <div class="row">
        <div class="col-md-6">
             <img class="img-responsive tarjeta" src=<?= "" . $srctarjetamas . "/tarjeta-mas-5.png"?> alt="">
        </div>      
        <div class="col-md-6">
            <img class="img-responsive tarjeta" src=<?= "" . $srctarjetamas . "/tarjeta-mas-10.png"?> alt="">
        </div>
      </div>
          
      <div class="space-1"></div>
      <p class="text-center">
          Ahora con la Tarjeta más tendrás la oportunidad de realizar tus compras con descuento en el momento en que lo necesites en la Rebaja Droguerías y Minimarkets.
          Adquiere tu tarjeta más en cualquier punto de venta y empieza a disfrutar  de descuentos preferenciales exclusivos para ti.  
      </p>
      <div class="space-1"></div>
      <div class="space-1"></div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <div class="white-item">
          <div class="default-icon left-icon big-icon company-bgcolor-1"></div>
          <h3>Activa tu tarjeta</h3>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="white-item">
          <div class="default-icon left-icon big-icon company-bgcolor-1"></div>
          <h3>Preguntas frecuentes</h3>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="white-item">
          <div class="default-icon left-icon big-icon company-bgcolor-1"></div>
          <h3>Atención al cliente (PQRS)</h3>
        </div>
      </div>
    </div>

  </section> <!-- / acerca de home -->
</div>

<div class="space-2"></div>
