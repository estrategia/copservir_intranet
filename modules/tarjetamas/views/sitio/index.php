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
      </div>

<div class="container internal">
  <section>  <!-- acerca de home -->
    <div class="acerca-home">
      <div class="space-1"></div>
      <div class="postIn">
        <h1 class="text-center">
            Ahora con la Tarjeta más tendrás la oportunidad de realizar tus compras con descuento en el momento en que lo necesites en la Rebaja Droguerías y Minimarkets.
        </h1>
        <h2 class="text-center" style="font-weight: bold;"><?= Html::a('Descubre cómo', ['/tarjetamas/sitio/informacion']) ?></h2> 
      </div>
      <div class="space-2"></div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <div class="postLeft white-item">
            <div class="default-icon big-icon company-bgcolor-1">
                <i class="fa fa-credit-card" aria-hidden="true"></i>
            </div>          
            <h3 style="font-weight: bold;">Activa tu tarjeta</h3>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="postIn white-item">
            <div class="default-icon big-icon company-bgcolor-1">
                <i class="fa fa-question" aria-hidden="true"></i>
            </div>
          <h3 style="font-weight: bold;" >Preguntas frecuentes</h3>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="postRight white-item">
            <div class="default-icon big-icon company-bgcolor-1">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
          <h3 style="font-weight: bold;">Atención al cliente (PQRS)</h3>
        </div>
      </div>
    </div>

  </section> <!-- / acerca de home -->
</div>

<div class="space-2"></div>
<?php
 $this->registerJs("jQuery('.postIn').viewportChecker({classToAdd: 'visible animated bounceIn', offset: 100});", \yii\web\View::POS_END);
 $this->registerJs("jQuery('.postLeft').viewportChecker({classToAdd: 'visible animated bounceInLeft', offset: 100});", \yii\web\View::POS_END);
  $this->registerJs("jQuery('.postRight').viewportChecker({classToAdd: 'visible animated bounceInRight', offset: 100});", \yii\web\View::POS_END);
?>    

