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
  <section>
    <div class="space-1"></div>  
      <div class="row">
          <div class="col-md-12">
              <img class="img-responsive" src=<?= "" . $srcProveedor . "/detalle-tarjeta-mas.jpg"?> alt="">  
          </div>          
      </div>
      <div class="space-2"></div>
      <div class="row">
          <div class="col-md-6">
              <blockquote class="text-justify" style="background-color: rgba(239, 239, 239, 0.28);">
                <i class="fa fa-caret-right" aria-hidden="true"></i>
                &nbsp;La Tarjeta más, es una membresía que te otorga descuentos por las compras que realices en cualquier punto de venta LA  REBAJA DROGUERIAS Y MINIMARKETS
                para que disfrutes de estos beneficios:  
            </blockquote>              
          </div> 
          <div class="col-md-6">
              <ul class="list">
                <li><strong>Facilidad</strong> de obtener un descuento cualquier día de la semana </li>
                <li><strong>Ahorro</strong> en tus compras cuando más lo necesites, sin esperar una fecha especial para obtener tu descuento.  </li>
                <li><strong>Disponibilidad</strong> para utilizar los descuentos adquiridos en cualquiera de los 800 puntos de venta en el país y las 24 horas del día en los puntos de venta con servicio 24 H.</li>
                <li><strong>Comodidad</strong> para realizar sus compras con descuento desde su hogar u oficina a través del servicio a domicilio.</li>
            </ul>              
          </div> 
      </div>
      
      <div class="space-2"></div>  
      <div class="row">    
          <div class="col-md-12">
             <h3 class="text-center" style="font-weight:bolder;" >Ven y vive la experiencia, visita cualquiera de nuestros puntos de venta en el país y adquiere tu <br> TARJETA MÁS en sus 2 versiones:</h3>
          </div>                  
      </div>
       <div class="space-2"></div>  


      <div class="row">
          <div class="col-md-6">              
              <img class="img-responsive center-block" width="400" src=<?= "" . $srcProveedor . "/tarjeta-mas-5.png"?> alt="">
          </div>
          <div class="col-md-6">  
              <div class="space-2"></div>
              <blockquote style="color:#D1282C;line-height: 29px;" >La Tarjeta más 5%, le otorga al portador de la tarjeta 48 descuentos del 5% durante un año, para las compras que realice en cualquier punto de venta 
              LA  REBAJA DROGUERIAS Y MINIMARKETS, con una vigencia de un año a partir del momento de la activación o el uso total del número de descuentos asignados,
              lo primero que suceda.
              </blockquote>
          </div>
      </div>
      <div class="space-1"></div>
       <div class="row">
          <div class="col-md-6">              
               <img class="img-responsive center-block" width="400" src=<?= "" . $srcProveedor . "/tarjeta-mas-10.png"?> alt="">
          </div>
          <div class="col-md-6">
              <div class="space-2"></div>             
              <blockquote style="color:#D1282C;line-height: 29px;">La Tarjeta más 10%, le otorga al portador de la tarjeta 36 descuentos del 10% durante un año, para las compras que realice en cualquier punto de venta LA  REBAJA DROGUERIAS Y MINIMARKETS,
                  con una vigencia de un año a partir del momento de la activación o el uso total del número de descuentos asignados, lo primero que suceda.  
              </blockquote>
          </div>
      </div>     
      <div class="space-1"></div>
     
  </section>    
</div>

<div class="space-2"></div>

  