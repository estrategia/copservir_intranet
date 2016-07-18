<?php

use yii\helpers\Html;

$this->title = 'Terminos y condiciones';
$srcProveedor = Yii::$app->homeUrl . 'img/multiportal/tarjetamas';
?>

<!-- colocar migas de pan -->
<div class="page-header">
    <div class="container">
        <div class="page-title">
            <h1>Términos y condiciones</h1>
            <div class="breadcrumbs"><?= Html::a('Inicio', ['/tarjetamas/sitio/index']) ?> / <?= Html::a('Tarjeta Más', ['/tarjetamas/sitio/informacion']) ?> / Términos y condiciones</div>
        </div>
    </div>
</div>

<div class="container">
    <section>
        <div class="space-1"></div>
        <ul class="postIn text-justify">
            <li>La tarjeta más es de venta exclusiva en los puntos de venta LA REBAJA DROGUERIAS Y MINIMARKET y su adquisición es únicamente de manera presencial. </li>
            <li>Podrán acceder a la compra de esta tarjeta personas naturales mayores de edad que realicen compras para su consumo propio o el de sus familiares, no podrán acceder a la compra empresas de ningún sector, ni tampoco trabajadores de Copservir Ltda.</li>
            <li>El comprador de la tarjeta más, deberá entregar sus datos personales validos aceptando la política de privacidad y protección de datos en el momento que efectúa la compra de su tarjeta más. Ver <?= Html::a('Política de Privacidad y Protección de Datos.', ['/tarjetamas/sitio/politicas']) ?> </li>  
            <li>Este programa a través de su tarjeta más 5%, le otorga al portador de la tarjeta 48 descuentos del 5% durante un año, para las compras que realice en cualquier punto de venta LA  REBAJA DROGUERIAS Y MINIMARKETS, con una vigencia de un año a partir del momento de la activación o el uso total del número de descuentos adquiridos, lo primero que suceda. La activación de la tarjeta más 5%, se realiza en el mismo momento de la compra.</li>
            <li>Este programa a través de su tarjeta más 10%, le otorga al portador de la tarjeta 36 descuentos del 10% durante un año, para las compras que realice en cualquier punto de venta LA  REBAJA DROGUERIAS Y MINIMARKETS, con una vigencia de un año a partir del momento de la activación o el uso total del número de descuentos adquiridos, lo primero que suceda. La activación de la tarjeta más 10%, se realiza en el mismo momento de la compra.</li>
            <li>La tarjeta más podrá utilizarse en compras que se realicen en los puntos de venta La Rebaja Droguerías y Minimarkets, incluye los puntos de venta con atención 24 horas y a través del servicio a domicilio en los pedidos solicitados por el canal telefónico.</li>
            <li>Para otorgar el descuento es indispensable la presentación de la tarjeta más en el punto de venta, al momento de realizar su compra. </li>
            <li>Para obtener el descuento a través del servicio a domicilio, al momento de realizar el pedido por el canal telefónico, debe mencionar que es portador de tarjeta más e indicar el número de cedula asociada; es necesaria la presentación de la tarjeta al momento de la entrega del pedido. </li>
            <li>El descuento no aplica en las compras realizadas a través de canal virtual</li>
            <li>El portador de la tarjeta más será el único responsable del uso indebido que se haga de ésta. Copservir Ltda. no se hace responsable por situaciones derivadas de su mala utilización</li>
            <li>El descuento es acumulable con otros descuentos vigentes por campañas, actividades o productos y aplica únicamente en facturas iguales o inferiores a $500.000.</li>
            <li>No se aceptan devoluciones de la tarjeta más después de su activación y cuando haya sido utilizado alguno de los descuentos.</li>
            <li>El descuento no aplica en leches, cereales infantiles, leches formuladas o maternizadas, cigarrillos, celulares, recargas, pines, tarjetas prepago, planes de telefonía celular voz y datos. No aplica tampoco al valor de los servicios Domicilio, Entrega Nacional, Baloto, Servicio de Bascula, Glucometria, inyectologia y toma de Presión.</li>
            <li>El cliente portador de la tarjeta más podrá consultar la vigencia de la tarjeta y los descuentos disponibles y utilizados <a href='<?= yii\helpers\Url::toRoute('usuario/mis-tarjetas') ?>' >AQUÍ</a>. </li>
            <li>En caso de pérdida, hurto o daño de la tarjeta más podrá realizar el bloqueo de su tarjeta <a href='<?= yii\helpers\Url::toRoute('usuario/mis-tarjetas') ?>' >AQUÍ</a> y solicitar su reposición</li>
            <li> La primera tarjeta activa tendrá el estado de tarjeta primaria. En los casos donde se utilice el  servicio a domicilio con tarjeta más, el descuento será debitado de la tarjeta primaria. En caso de poseer más de una Tarjeta, se podrá cambiar el estado a primaria ingresando  a  <a target="_BLANK" href="http://tarjetamaslarebaja.com">www.tarjetamaslarebaja.com</a>, dar clic en la opción “ver tarjetas”, escoger la tarjeta que se quiere hacer primaria.</li> 
        </ul>
    </section>
</div>

<div class="space-2"></div>

<?php
$this->registerJs("jQuery('.postIn').viewportChecker({classToAdd: 'visible animated fadeInLeft', offset: 100});", \yii\web\View::POS_END);
?>   