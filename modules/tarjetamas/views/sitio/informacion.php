<?php
use yii\helpers\Html;
$this->title = 'Tarjeta Mas';
$srcProveedor = Yii::$app->homeUrl . 'img/multiportal/tarjetamas';
?>

 <!-- colocar migas de pan -->
<div class="page-header">
   <div class="container">
      <div class="page-title">
        <h1>¿Qué es la Tarjeta Más?</h1>
        <div class="breadcrumbs"><?= Html::a('Inicio', ['/tarjetamas/sitio/index']) ?> / Tarjeta Más</div>
      </div>
   </div>
</div>
<div class="container-fuild">
    <div class="row">
          <img class="img-responsive" src="<?= "" . $srcProveedor . "/banner-intranet-tarjeta-mas.jpg"?>" alt="Tarjeta más">  
    </div>

</div>

<div class="container">
  <section>
      <div class="space-2"></div>
      <div class="row">
          <div class="col-md-12">
              <blockquote class="postLeft text-justify" style="background-color: rgba(239, 239, 239, 0.28);">
                <i class="fa fa-caret-right" aria-hidden="true"></i>
                &nbsp;La Tarjeta más, te otorga descuentos durante un año por las compras que realices en cualquier punto de venta LA  REBAJA DROGUERIAS Y MINIMARKETS para que disfrutes de estos beneficios:  
            </blockquote>              
          </div> 
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="postIn col-md-3">
                <ul class="list">
                  <li><strong>Facilidad</strong> de obtener un descuento cualquier día de la semana </li>
                </ul> 
              </div>
              <div class="postIn col-md-3">
                <ul class="list">
                  <li><strong>Ahorro</strong> en tus compras cuando más lo necesites, sin esperar una fecha especial para obtener tu descuento.  </li>
                </ul> 
              </div>
              <div class="postIn col-md-3">
                <ul class="list">
                  <li><strong>Disponibilidad</strong> para utilizar los descuentos adquiridos en cualquiera de los 800 puntos de venta en el país y las 24 horas del día en los puntos de venta con servicio 24 H.</li>
                </ul> 
              </div>
              <div class="postIn col-md-3">
                <ul class="list">
                    <li><strong>Comodidad</strong> para realizar sus compras con descuento desde su hogar u oficina a través del servicio a domicilio.</li>
                </ul> 
              </div>
          </div> 
      </div>
      <div class="space-2"></div>  
      <div class="row">    
          <div class="postPulse col-md-12">
             <h3 class="text-center" style="font-weight:bolder;" >Ven y vive la experiencia, visita cualquiera de nuestros puntos de venta en el país y adquiere tu <br> TARJETA MÁS en sus 2 versiones:</h3>
          </div>                  
      </div>
       <div class="space-2"></div>  


      <div class="row">
          <div class="fadeLeft col-md-6">              
              <img class="img-responsive center-block" width="400" src=<?= "" . $srcProveedor . "/tarjeta-mas-5.png"?> alt="">
              <div class="space-1"></div>
              <blockquote style="color:#D1282C;">En 48 compras durante un año </blockquote>
          </div>
          <div class="fadeRight col-md-6">  
              <img class="img-responsive center-block" width="400" src=<?= "" . $srcProveedor . "/tarjeta-mas-10.png"?> alt="">
              <div class="space-1"></div>             
              <blockquote style="color:#D1282C;">En 36 compras durante un año </blockquote>
          </div>
      </div>
      <div class="space-1"></div>
     
  </section>    
</div>

<div class="space-2"></div>

<?php
 $this->registerJs("jQuery('.postIn').viewportChecker({classToAdd: 'visible animated bounceIn', offset: 100});", \yii\web\View::POS_END); 
 $this->registerJs("jQuery('.postLeft').viewportChecker({classToAdd: 'visible animated bounceInLeft', offset: 100});", \yii\web\View::POS_END);
 $this->registerJs("jQuery('.postPulse').viewportChecker({classToAdd: 'visible animated pulse', offset: 100});", \yii\web\View::POS_END);
 $this->registerJs("jQuery('.fadeLeft').viewportChecker({classToAdd: 'visible animated fadeInLeft', offset: 100});", \yii\web\View::POS_END);
 $this->registerJs("jQuery('.fadeRight').viewportChecker({classToAdd: 'visible animated fadeInRight', offset: 100});", \yii\web\View::POS_END);
?>      