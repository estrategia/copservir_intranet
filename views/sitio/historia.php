<?php
// Rutas imagenes
$srcHistoria = Yii::$app->homeUrl . 'img/multiportal/copservir/historia.png';
$srcIconMovie = Yii::$app->homeUrl . 'img/multiportal/copservir/cd-icon-movie.svg';
$srcIconPicture = Yii::$app->homeUrl . 'img/multiportal/copservir/cd-icon-picture.svg';
$srcIconLocation = Yii::$app->homeUrl . 'img/multiportal/copservir/cd-icon-location.svg';

?>
    <div class="page-header">
      <div class="container">
        <div class="page-title">
          <h1>Historia</h1>
          <div class="breadcrumbs">Inicio / Quienes somos / Historia</div>
        </div>
      </div>
    </div>

    <div class="container internal">
      <h2>Nuestra historia</h2>
      <p>Cumplimos 20 años desde que iniciamos este camino y queremos compartir nuestro<br> orgullo de consolidarnos hoy como la red de droguerías más grande del país. Conozca<br> más de nuestra historia.</p>
      <div class="space-1"></div>
      <img style="border-radius: 10px;" src=<?= "" . $srcHistoria ?> alt="">
      <div class="space-1"></div>
      <h2>Ruta de sueños alcanzados</h2>
      <section id="cd-timeline" class="cd-container">
        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-picture">
            <img src=<?= "" . $srcIconPicture ?> alt="Picture">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Title of section 1</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.</p>


          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-movie">
            <img src=<?= "" . $srcIconMovie ?> alt="Movie">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Title of section 2</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde?</p>


          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-picture">
            <img src=<?= "" . $srcIconPicture ?> alt="Picture">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Title of section 3</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, obcaecati, quisquam id molestias eaque asperiores voluptatibus cupiditate error assumenda delectus odit similique earum voluptatem doloremque dolorem ipsam quae rerum quis. Odit, itaque, deserunt corporis vero ipsum nisi eius odio natus ullam provident pariatur temporibus quia eos repellat consequuntur perferendis enim amet quae quasi repudiandae sed quod veniam dolore possimus rem voluptatum eveniet eligendi quis fugiat aliquam sunt similique aut adipisci.</p>


          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src=<?= "" . $srcIconLocation ?> alt="Location">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Title of section 4</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.</p>


          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src=<?= "" . $srcIconLocation ?> alt="Location">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Title of section 5</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum.</p>


          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-movie">
            <img src=<?= "" . $srcIconMovie ?> alt="Movie">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>Final Section</h2>
            <p>This is the content of the last section</p>
            <span class="cd-date">Feb 26</span>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->
      </section> <!-- cd-timeline -->
    </div>
    <div class="space-2"></div>
