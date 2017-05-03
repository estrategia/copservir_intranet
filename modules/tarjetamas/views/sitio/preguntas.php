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
                      La tarjeta más es de venta exclusiva en los puntos de venta LA REBAJA DROGUERIAS Y MINIMARKET. Su venta no está disponible para los canales telefónico y virtual. 
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
                      Si es acumulable con otros descuentos otorgados por campañas.
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
                  <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="once">
                        <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseonce" aria-expanded="false" aria-controls="collapseonce">
                           ¿Qué es una tarjeta más primaria?
                          </a>
                        </h4>
                      </div>
                      <div id="collapseonce" class="panel-collapse collapse" role="tabpanel" aria-labelledby="once">
                        <div class="panel-body">
                         Hace referencia a la primera tarjeta activa  de la cual se debitan los usos de descuento que realice a través del servicio a domicilio.  En caso de poseer más de una tarjeta  más
                         podrá seleccionar como tarjeta primaria la que desee, esta opción se realiza ingresando  a <a href="http://tarjetamaslarebaja.com" target="_BLANK">www.tarjetamaslarebaja.com</a>, dar clic en la opción “ver tarjetas”, escoger la tarjeta que desea hacer primaria. 
                        </div>
                      </div>
                  </div>
                   <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="doce">
                        <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsedoce" aria-expanded="false" aria-controls="collapsedoce">
                           ¿Hay un valor máximo de compra para obtener el descuento? 
                          </a>
                        </h4>
                      </div>
                      <div id="collapsedoce" class="panel-collapse collapse" role="tabpanel" aria-labelledby="doce">
                        <div class="panel-body">
                         La compra máxima por factura con el descuento de Tarjeta más, es hasta $500.000.
                        </div>
                      </div>
                  </div>
              
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="trece">
                        <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetrece" aria-expanded="false" aria-controls="collapsetrece">
                           ¿Qué debo hacer si mi compra supera los $500.000?
                          </a>
                        </h4>
                      </div>
                      <div id="collapsetrece" class="panel-collapse collapse" role="tabpanel" aria-labelledby="trece">
                        <div class="panel-body">
                         Se deberá dividir la compra en varias facturas, donde cada una de éstas no superen los $500.000.
                        </div>
                      </div>
                  </div>             
         </div>
      </div>
      <div class="postRight col-md-5">
          
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <img width="400" class="img-responsive" src=<?= "" . $srcProveedor . "/tarjeta-mas-5.png" ?> alt="">
                </div>

                <div class="item">
                  <img width="400" class="img-responsive" src=<?= "" . $srcProveedor . "/tarjeta-mas-10.png" ?> alt="">
                </div>
              </div>
            </div>          
      </div>

  </section>

</div>
<div class="space-2"></div>

<?php
 $this->registerJs("jQuery('.postLeft').viewportChecker({classToAdd: 'visible animated fadeInLeft', offset: 100});", \yii\web\View::POS_END);
 $this->registerJs("jQuery('.postRight').viewportChecker({classToAdd: 'visible animated fadeInRight', offset: 100});", \yii\web\View::POS_END);
?>   