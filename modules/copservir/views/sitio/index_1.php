<?php
use yii\helpers\Html;

$this->title = 'Copservir';

// Rutas imagenes
$srcSlide = Yii::$app->homeUrl . 'img/multiportal/copservir/slide_1.jpg';
?>

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src=<?= "" . $srcSlide ?> alt="First slide">
        </div>
        <div class="item">
          <img class="second-slide" src=<?= "" . $srcSlide ?> alt="Second slide">
        </div>
        <div class="item">
          <img class="third-slide" src=<?= "" . $srcSlide ?> alt="Third slide">

        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">
      <section>  <!-- acerca de home -->
        <div class="acerca-home">
          <h2>Somos ejemplo de permanencia, fortaleza y consolización.</h2>
          <div class="space-1"></div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare commodo sagittis. Quisque cursus, nisi a bibendum posuere, nisl dolor egestas eros, vitae feugiat ipsum ipsum eget sapien. Fusce laoreet bibendum accumsan. Sed dui odio, elementum sit amet ligula eu, porta pharetra leo. Nunc sed velit imperdiet, rutrum quam at, pulvinar velit.</p>
          <div class="space-1"></div>
        </div>



      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-sm-4 centered">
          <img src="http://placehold.it/400x250" class="img-responsive">
          <p>Queremos llegar a cada rincón del país</p>
        </div><!-- /.col-lg-4 -->
        <div class="col-sm-4 centered">
          <img src="http://placehold.it/400x250" class="img-responsive">
          <p>Somos innovadores en servicio</p>
        </div><!-- /.col-lg-4 -->
        <div class="col-sm-4 centered">
          <img src="http://placehold.it/400x250" class="img-responsive">
          <p>Asumimos compromiso de sustentabilidad</p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

      </section> <!-- / acerca de home -->
      </div>
      <div class="space-2"></div>
      <section> <!-- full section -->
        <div class="bg-parallax">
          <div class="container green-container">
          <div class="green-square">
            <h2>Aportamos a nuestra sociedad a través de la cooperación y el apoyo mutuo entre individuos para ofrecer a la comunidad servicios o artículos en las condiciones más beneficiosas</h2>
          </div>
          </div>
        </div>
      </section> <!-- / full section -->
     <!--  <div class="space-2"></div>
      <div class="space-2"></div> -->
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
