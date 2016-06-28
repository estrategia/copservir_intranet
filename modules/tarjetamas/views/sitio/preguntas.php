<?php
use yii\helpers\Html;
$this->title = 'Preguntas frecuentes';
$srcProveedor = Yii::$app->homeUrl . 'img/multiportal/tarjetamas';
?>

<!-- colocar migas de pan -->
<div class="page-header">
   <div class="container">
      <div class="page-title">
        <h1>Preguntas frecuentes</h1>
        <div class="breadcrumbs"><?= Html::a('Inicio', ['/tarjetamas/sitio/index']) ?> / preguntas frecuentes</div>
      </div>
   </div>
</div>
 

<div class="container ">
    <section>        
      <div class="space-1"></div>
      
      <div class="postLeft col-md-7">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                         Donde puedo adquirir la tarjeta más?
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                      La tarjeta más es de venta exclusiva a partir del 1 de julio de 2016 en los puntos de venta LA REBAJA DROGUERIAS Y MINIMARKET. Su venta no está disponible para los canales telefónico y virtual. Disponibles 30.000 unidades. 
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        He perdido mi Tarjeta más. ¿Qué debo hacer?
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <ul>
                        <li>Ingresa a la pestaña Atención al Cliente que te llevará al sistema de atención PQRS (Peticiones, quejas, reclamos y sugerencias).</li>
                        <li>Selecciona el asunto: Reporte pérdida tarjeta más. </li>
                        <li>Crea la petición</li>
                        <li>Un Asesor del Call center realizará la gestión de solicitud de reposición de tarjeta.</li>
                        <li>La tarjeta más la recibirá en un período de 20 días hábiles.</li>
                        <li>El período de esta pérdida no incrementará la vigencia de los descuentos. </li>
                        <li>La reposición de la tarjeta no tiene ningún costo. </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        ¿Puedo utilizar mi tarjeta más en servicio a domicilio?
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                      Si, al momento de solicitar tu pedido debes mencionar que eres portador de la tarjeta más e indicar el número de cedula asociado a la tarjeta. La presentación de la tarjeta mas es indispensable al momento de la entrega del pedido. 
                    </div>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="cuatro">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsecuatro" aria-expanded="false" aria-controls="collapsecuatro">
                         ¿Puedo utilizar los descuentos de la tarjeta más en la tienda virtual?
                      </a>
                    </h4>
                  </div>
                  <div id="collapsecuatro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cuatro">
                    <div class="panel-body">
                      No aplica su uso en la tienda virtual. Puede utilizarla únicamente los puntos de venta o a través de los pedidos por el canal telefónico. 
                    </div>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="cinco">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsecinco" aria-expanded="false" aria-controls="collapsecinco">
                         ¿Cuántas tarjeta más puedo adquirir?
                      </a>
                    </h4>
                  </div>
                  <div id="collapsecinco" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cinco">
                    <div class="panel-body">
                      Podrás adquirir el número de tarjetas que desees, no existe una restricción en el número de tarjetas. La venta de tarjeta más está restringida a empresas o instituciones de cualquier sector.  
                    </div>
                  </div>
                </div>  

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="seis">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseseis" aria-expanded="false" aria-controls="collapseseis">
                        Cuál es la vigencia de mi tarjeta más?
                      </a>
                    </h4>
                  </div>
                  <div id="collapseseis" class="panel-collapse collapse" role="tabpanel" aria-labelledby="seis">
                    <div class="panel-body">
                     La vigencia es de un año a partir del momento de la activación o cuando utilice todos los descuentos adquiridos. Lo primero que suceda. 
                    </div>
                  </div>
                </div>  

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="siete">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsesiete" aria-expanded="false" aria-controls="collapsesiete">
                        Si tengo dos tarjetas puedo acumular el descuento en una misma compra?
                      </a>
                    </h4>
                  </div>
                  <div id="collapsesiete" class="panel-collapse collapse" role="tabpanel" aria-labelledby="siete">
                    <div class="panel-body">
                    En ningún caso los descuentos de tarjeta más son acumulables para una misma. 
                    </div>
                  </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="ocho">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseocho" aria-expanded="false" aria-controls="collapseocho">
                          El descuento de la tarjeta más, es acumulable con otros descuentos?
                        </a>
                      </h4>
                    </div>
                    <div id="collapseocho" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ocho">
                      <div class="panel-body">
                      ...
                      </div>
                    </div>
                  </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="nueve">
                          <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsenueve" aria-expanded="false" aria-controls="collapsenueve">
                               Que beneficios tengo al adquirir la tarjeta más?
                            </a>
                          </h4>
                        </div>
                        <div id="collapsenueve" class="panel-collapse collapse" role="tabpanel" aria-labelledby="nueve">
                          <div class="panel-body">
                            <ul>
                              <li><strong>Facilidad</strong> de obtener un descuento cualquier día de la semana.</li>
                              <li><strong>Ahorro</strong> en sus compras cuando más lo necesite, sin esperar una fecha especial para obtener un descuento.  </li>
                              <li><strong>Disponibilidad</strong> para utilizar los descuentos adquiridos en cualquiera de los 800 puntos de venta en el país y las 24 horas del día en los puntos de venta con servicio 24 H.</li>
                              <li><strong>Comodidad</strong> para realizar sus compras con descuento desde su hogar u oficina a través del servicio a domicilio.</li>
                             </ul>
                          </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="diez">
                        <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsediez" aria-expanded="false" aria-controls="collapsediez">
                            ¿Si salgo de viaje puedo suspender el período de la tarjeta y reactivarlo cuando regrese?
                          </a>
                        </h4>
                      </div>
                      <div id="collapsediez" class="panel-collapse collapse" role="tabpanel" aria-labelledby="diez">
                        <div class="panel-body">
                          No, a partir del momento de la activación de la tarjeta su vigencia es de un año o vencerá también cuando se utilicen todos los descuentos adquiridos. 
                        </div>
                      </div>
                  </div>
         </div>
      </div>
      <div class="postRight col-md-5">
          <img width="400" class="img-responsive" src=<?= "" . $srcProveedor . "/preguntas-frecuentes.jpg" ?> alt="">
      </div>

  </section>

</div>
<div class="space-2"></div>

<?php
 $this->registerJs("jQuery('.postLeft').viewportChecker({classToAdd: 'visible animated fadeInLeft', offset: 100});", \yii\web\View::POS_END);
 $this->registerJs("jQuery('.postRight').viewportChecker({classToAdd: 'visible animated fadeInRight', offset: 100});", \yii\web\View::POS_END);
?>   