<?php
use yii\helpers\Html;
$this->title = 'Nuestro Compromiso social';

// Rutas imagenes
$srcMision = Yii::$app->homeUrl . 'img/multiportal/copservir/nuestro-compromiso.jpg';
?>
    <!-- Migas de pan
    ================================================== -->


    <div class="page-header">
      <div class="container">
        <div class="page-title">
          <h1>Nuestro compromiso social</h1>
          <div class="breadcrumbs"><?= Html::a('Inicio', ['/copservir']) ?>  / Nuestro compromiso social</div>
        </div>
      </div>
    </div>

    <div class="container internal">
        <img class="img-responsive" style="border-radius: 10px;" src=<?= "" . $srcMision ?> alt="">
         <div class="space-2"></div>
      <p>
        En Copservir nos mueve una fuerte convicción de servicio que nos impulsa a realizar diferentes acciones para cambios sociales que contribuyan a mejorar la vida de las personas, cuidamos el medio ambiente y trabajamos por el mejoramiento de la calidad de vida de las comunidades menos favorecidas.
      </p>
      <div class="space-2"></div>
    </div>
      <div class="gray-sec">
        <div class="container internal">
          <div class="col-sm-12">
            <div>
              <h3>Fundacion Copservir </h3>
              <p>
                  Pensando en brindar salud y Bienestar a la comunidad más vulnerable del país, un grupo de personas vinculadas a nuestra cooperativa Copservir y sensibilizados por una realidad excluyente, nos unimos a través de una organización como nuestra fundación, para brindar apoyo a los seres humanos menos favorecidos. Así nace nuestra  FUNDACION COPSERVIR “Un corazón dispuesto a servir”, realizando actividades especificas de promoción social, tendientes a apoyar el desarrollo de las diferentes comunidades Colombianas con carencia de recursos que limitan su desarrollo personal, social y familiar. <br>
                    Ingresa a <?= Html::a('www.fundacioncopservir.org', ['http://fundacioncopservir.org']) ?> y juntos apoyemos a las comunidades menos favorecidas.

              <p>
            </div>
          </div>
        </div>
      </div>
      <div class="space-1"></div>
    <!--<div class="container internal text-left">
      <h2>Valores corporativos</h2>
      <div class="space-2"></div>
      <div class="row">
        <div class="col-sm-4">
          <div class="white-item">
          <div class="default-icon left-icon big-icon"></div>
          <h3>Integridad</h3>
          <p>Hacemos lo correcto.</p>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="white-item">
          <div class="default-icon left-icon big-icon"></div>
          <h3>Satisfacción del cliente</h3>
          <p>Creamos experiencias memorables.</p>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="white-item">
          <div class="default-icon left-icon big-icon"></div>
          <h3>Respeto</h3>
          <p>Valoramos a las personas, reconocemos su disgnidad y acatamos la autoridad.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="white-item">
          <div class="default-icon left-icon big-icon"></div>
          <h3>Pasión</h3>
          <p>Disfrutamos lo que hacemos.</p>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="white-item">
          <div class="default-icon left-icon big-icon"></div>
          <h3>Proactividad</h3>
          <p>Tomamos la iniciativa y nos hacemos parte de la solución. Orientados y regulados en los principios y valores, Copservir implementa los siguientes objetivos estratégicos que le permiten cumplir con su misión, inspirados en la visión.</p>
          </div>
        </div>
      </div>
    </div>-->
    <div class="space-2"></div>
