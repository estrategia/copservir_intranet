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
 <div class="container">
      <div class="row">
          <div class="fadeLeft col-md-6">              
              <img class="img-responsive center-block" width="400" src=<?= "" . $srcProveedor . "/tarjeta-mas-5.png"?> alt="">
              <p style="color:#D1282C;text-align:center;">En 48 compras durante un año </p>
          </div>
          <div class="fadeRight col-md-6">  
              <img class="img-responsive center-block" width="400" src=<?= "" . $srcProveedor . "/tarjeta-mas-10.png"?> alt="">
              <p style="color:#D1282C;text-align:center;">En 36 compras durante un año </p>
          </div>
      </div>
 </div>
<div class="container">
  <section>
      <div class="space-2"></div>
      <div class="row">
          <div class="col-md-12">
              <blockquote class="postLeft text-justify" style="background-color: rgba(239, 239, 239, 0.28);">
                BENEFICIOS   
            </blockquote>              
          </div> 
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="postIn col-md-3 col-sm-3 col-xs-6">
                  <div class="section-red">
                      <img class="img-responsive" src="<?= "" . $srcProveedor . "/facilidad.png"?>" alt="Facilidad">                 
                      <p style="text-align: center;">de obtener un descuento cualquier día de la semana </p>
                  </div>                
              </div>
              <div class="postIn col-md-3 col-sm-3 col-xs-6">
                  <div class="section-red">
                    <img class="img-responsive" src="<?= "" . $srcProveedor . "/ahorro.png"?>" alt="Ahorro"> 
                    <p style="text-align: center;">en tus compras cuando más lo necesites, sin esperar una fecha especial para obtener tu descuento.</p>  
                  </div>
              </div>
              <div class="postIn col-md-3 col-sm-3 col-xs-6">
              <div class="section-red">
                  <img class="img-responsive" src="<?= "" . $srcProveedor . "/disponibilidad.png"?>" alt="Disponibilidad"> 
                  <p style="text-align: center;">para utilizar los descuentos adquiridos en cualquiera de los 800 puntos de venta en el país y las 24 horas del día en los puntos de venta con servicio 24 H.</p>
              </div>
              </div>
              <div class="postIn col-md-3 col-sm-3 col-xs-6">
                <div class="section-red">
                   <img class="img-responsive" src="<?= "" . $srcProveedor . "/comodidad.png"?>" alt="Comodidad">  
                   <p style="text-align: center;">para realizar sus compras con descuento desde su hogar u oficina a través del servicio a domicilio.</p>  
                </div>
                
              </div>
          </div> 
      </div>
      <div class="space-2"></div>  
      <div class="row">    
          <div class="postPulse col-md-12">
             <h3 class="text-center" style="font-weight:bolder;" > Visita cualquier punto de venta La Rebaja Droguerías y Minimarket y adquiere tu tarjeta más.</h3>
          </div>                  
      </div>
       <div class="space-2"></div>  



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