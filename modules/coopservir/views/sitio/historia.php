<?php
use yii\helpers\Html;
$this->title = 'Historia';

// Rutas imagenes
$srcHistoria = Yii::$app->homeUrl . 'img/multiportal/copservir/nuestra-historia.jpg';
$srcIconMovie = Yii::$app->homeUrl . 'img/multiportal/copservir/cd-icon-movie.svg';
$srcIconPicture = Yii::$app->homeUrl . 'img/multiportal/copservir/cd-icon-picture.svg';
$srcIconLocation = Yii::$app->homeUrl . 'img/multiportal/copservir/cd-icon-location.svg';

?>
    <div class="page-header">
      <div class="container">
        <div class="page-title">
          <h1>Nuestra Historia</h1>
          <div class="breadcrumbs"><?= Html::a('Inicio', ['/coopservir']) ?> / Nuestra Historia</div>
        </div>
      </div>
    </div>

    <div class="container internal">
      <div class="space-1"></div>
      <img style="border-radius: 10px;" src=<?= "" . $srcHistoria ?> alt="">
      <div class="space-1"></div>
      <p>
          Hace más de 20 años nuestros trabajadores, se asociaron con el sueño de ser una de las cadenas más grandes de farmacias en Colombia y desde ese entonces juntos hemos establecido más de 470 puntos de venta, este logro no hubiera sido posible sin los aportes mensuales realizados por nuestros asociados, el trabajo en equipo y el emprendimiento que cada uno desde sus lugares de trabajo aporta a nuestra cooperativa, Copservir, convirtiéndola en un modelo de atención único en el país, haciendo del cooperativismo y servicio pilares de nuestra filosofía empresarial. En todos estos años el esfuerzo y dedicación nos ha permitido consolidarnos como uno de los gigantes en la distribución de medicamentos en Colombia, con un modelo de negocio fortalecido y tendiente a expandirse. 
      </p>
      <p>Credibilidad y confianza determinan nuestra relación con los clientes en las diferentes regiones del país, pues somos una empresa que propende por la protección de los derechos del cliente, el mejoramiento continuo de nuestros protocolos de atención y la prevención del fraude. Nuestra marca La Rebaja Droguería es una vecina de siempre, transformada en sus estructuras para el beneficio de nuestros usuarios y trabajadores, en una historia que escribimos juntos en pro de la defensa del derecho al trabajo al éxito organizativo. </p>
      <h2>Nuestra Historia año a año</h2>
      <section id="cd-timeline" class="cd-container">
          
        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-picture">
            <img src=<?= "" . $srcIconPicture ?> alt="Picture">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>1995</h2>
            <p>Nace Copservir Ltda: La asociación de trabajadores que conforman Copservir,  adquirió en 1996, un total de 320 droguerías  y desde ese entonces ha establecido más de 480 puntos de venta, con el producto de sus ingresos.</p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-movie">
            <img src=<?= "" . $srcIconMovie ?> alt="Movie">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>1999</h2>
            <p>Se crea un nuevo formato de negocio denominado <strong> Minimarket</strong>, Puntos de venta donde su modalidad de comercialización es el autoservicio, que cuentan con un amplio surtido de productos de consumo inmediato. </p>
            <p>Se da avance al <strong>Servicio A Domicilio</strong>, brindándoles así a los clientes de La Rebaja Droguería más y mejores servicios para su comodidad</p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-picture">
            <img src=<?= "" . $srcIconPicture ?> alt="Picture">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2002</h2>
            <p>Desarrollo del <strong>Servicio 24 horas</strong>,  Surge la <strong>Línea de atención al cliente</strong>, y se presentan nuevas Actualizaciones en Tecnología.</p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src=<?= "" . $srcIconLocation ?> alt="Location">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2003</h2>
            <p>Se crea el <strong>Servicio de Venta Nacional</strong>, generando la facilidad para los clientes de comprar en el lugar donde se encuentren y entregarlo donde ellos necesiten. Se hace el desarrollo de navegabilidad en internet para los empleados.  Y sale al aire la Primera <strong>tienda Virtual</strong>.</p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src=<?= "" . $srcIconLocation ?> alt="Location">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2004</h2>
            <p>Lanzamiento del portal web diseñado especialmente para los <strong>Proveedores</strong> de La Rebaja Droguería.</p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-movie">
            <img src=<?= "" . $srcIconMovie ?> alt="Movie">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2006</h2>
            <p>Nace la estrategia <strong>CRM</strong> donde lo que Copservir pretende es mantener una relación cercana con sus clientes, obteniendo información que le permita hacer una continua reciprocidad en pro del mejoramiento de los servicios que La Rebaja Droguería ofrece. </p>
            <span class="cd-date">Feb 26</span>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->
        
 
        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src=<?= "" . $srcIconLocation ?> alt="Location">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2008</h2>
            <p>Se crea <strong>Fundación Copservir</strong>, como respuesta al cumplimiento de uno de los principios cooperativos: La Solidaridad, y con el gran objetivo de llegar a las poblaciones donde La Rebaja Droguería hace presencia y lograr impactar a las personas que más lo necesiten con sus programas de promoción social. </p>
            <p>Se crea el  <strong>Modelo de capacitación Virtual </strong>debido a las distancias geográficas, esta herramienta se desarrolló para permitir que el personal realizara su inducción general y capacitaciones que ofrece la cooperativa de manera virtual, sin necesidad de desplazamientos. </p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->
        

         <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-movie">
            <img src=<?= "" . $srcIconMovie ?> alt="Movie">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2010</h2>
            <p>Se logra la negociación y compra de 40 farmacias en el departamento de Antioquia, permitiendo el crecimiento Horizontal de La Rebaja Droguería. <br> 
            Nace el <strong>Fondo Muto de Inversión Mi Futuro</strong>como una alternativa de ahorro para los trabajadores de Copservir.
            </p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->
        
  
        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src=<?= "" . $srcIconLocation ?> alt="Location">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2011</h2>
            <p>Copservir incursiona en los <strong>Social Media</strong>, generando información, creando conversación, animando a las personas a participar, y posicionando la presencia en la red de la marca La Rebaja Droguería. </p>
            <p><strong>Numero Único</strong> Para facilidad de nuestros clientes se desarrolló este sistema de comunicación que permite ubicar el punto de venta más cercano de acuerdo al lugar de donde se está realizando la llamada.</p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->       
        
 
         <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-movie">
            <img src=<?= "" . $srcIconMovie ?> alt="Movie">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2014</h2>
            <p> <strong>Ventas empresariales</strong> Es un área creada para establecer convenios con Fondos de empleados o empresas donde se le brinda a las personas pertenecientes a estos un descuento preferencial en el momento de la compra en La Rebaja Drogueria </p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->
        
   
        <div class="cd-timeline-block">
          <div class="cd-timeline-img cd-location">
            <img src=<?= "" . $srcIconLocation ?> alt="Location">
          </div> <!-- cd-timeline-img -->

          <div class="cd-timeline-content">
            <h2>2015</h2>
            <p><strong>Flota de mensajeros:</strong>  Se cuenta con una flota completa de mensajeros para el servicio de nuestros clientes.</p>
          </div> <!-- cd-timeline-content -->
        </div> <!-- cd-timeline-block -->          
        
        
      </section> <!-- cd-timeline -->
    </div>
    <div class="space-2"></div>
