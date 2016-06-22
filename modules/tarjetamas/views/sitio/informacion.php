<?php
use yii\helpers\Html;
$this->title = 'Tarjeta Mas';
$srcProveedor = Yii::$app->homeUrl . 'img/multiportal/tarjetamas';
?>

<div class="container">
  <section>
    <div class="">
      <div class="space-2"></div>
      <div class="space-2"></div>
      <h1>Tarjeta Más</h1>  
      <div class="row">
          <img class="img-responsive" src=<?= "" . $srcProveedor . "/detalle-tarjeta-mas.jpg"?> alt="">
      </div>
      <div class="space-1"></div>
      <p class="text-justify">
          La Tarjeta más, es una membresía que te otorga descuentos por las compras que realices en cualquier punto de venta LA  REBAJA DROGUERIAS Y MINIMARKETS
          para que disfrutes de estos beneficios:  
      </p>
      <ul>
          <li><strong>Facilidad</strong> de obtener un descuento cualquier día de la semana </li>
          <li><strong>Ahorro</strong> en tus compras cuando más lo necesites, sin esperar una fecha especial para obtener tu descuento.  </li>
          <li><strong>Disponibilidad</strong> para utilizar los descuentos adquiridos en cualquiera de los 800 puntos de venta en el país y las 24 horas del día en los puntos de venta con servicio 24 H.</li>
          <li><strong>Comodidad</strong> para realizar sus compras con descuento desde su hogar u oficina a través del servicio a domicilio.</li>
      </ul>
      <p class="text-justify" >ven y vive la experiencia, visita cualquiera de nuestros puntos de venta en el país y adquiere tu TARJETA MÁS en sus 2 versiones:</p>
      <div class="space-1"></div>
      <div class="row">
          <div class="col-md-6">              
              <img class="img-responsive tarjeta center-block" width="400" src=<?= "" . $srcProveedor . "/tarjeta-mas-5.png"?> alt="">
              <div class="space-1"></div>
              <p class="text-justify" >La <strong>Tarjeta más 5%</strong>, le otorga al portador de la tarjeta 48 descuentos del 5% durante un año, para las compras que realice en cualquier punto de venta 
              LA  REBAJA DROGUERIAS Y MINIMARKETS, con una vigencia de un año a partir del momento de la activación o el uso total del número de descuentos asignados,
              lo primero que suceda.
              </p>
          </div>
          <div class="col-md-6">              
              <img class="img-responsive tarjeta center-block" width="400" src=<?= "" . $srcProveedor . "/tarjeta-mas-10.png"?> alt="">
              <div class="space-1"></div>
              <p class="text-justify" ><strong>La Tarjeta más 10%</strong>, le otorga al portador de la tarjeta 36 descuentos del 10% durante un año, para las compras que realice en cualquier punto de venta LA  REBAJA DROGUERIAS Y MINIMARKETS,
                  con una vigencia de un año a partir del momento de la activación o el uso total del número de descuentos asignados, lo primero que suceda.  
              </p>
          </div>
      </div>
      <div class="space-1"></div>
    </div> 
  </section>    
</div>

<div class="space-2"></div>

  