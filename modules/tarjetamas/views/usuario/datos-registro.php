<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\UsuarioTarjetaMas */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Registro de Datos';
?>

<div class="container">
    <div class="space-2"></div>
    <div class="space-2"></div>
    <div class="row">
        <div class="col-md-12">

            <h2><?= Html::encode($this->title) ?></h2>

            <?= $this->render('/common/errores', []) ?>

            <div class="space-1"></div>

            <div class="col-md-offset-3 col-md-6">
                <?php $form = ActiveForm::begin(['options' => ['id' => 'formMenuportales']]); ?>

                <?= $form->field($model, 'numeroDocumento')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'primerApellido')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'segundoApellido')->textInput(['maxlength' => true]) ?>

               

                <?=
                $form->field($model, 'codigoCiudad')->widget(Select2::classname(), [
                    'data' => $model->getListaCiudad(),
                    'options' => ['placeholder' => 'Seleccione la ciudad']
                ]);
                ?>

                <?= $form->field($model, 'correo')->input('email') ?>

                <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'telefonoFijo')->textInput(['maxlength' => true]) ?>

                <?php if($model->scenario == 'registroDatos'):?>
                    <?= $form->field($model, 'password', [])->passwordInput(); ?>
                <?php endif;?>

                <?= $form->field($model, 'aceptaTerminos', [])->checkbox(); ?>

                <div class="col-md-3">
                    <div class="form-group">
                        <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Cancelar', ['sitio/index'], ['class' => 'btn btn-danger']) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                    $modal = Modal::begin([
                                'header' => '<h2>Politica de privacidad</h2>',
                                'toggleButton' => ['label' => 'Ver política de privacidad', 'class' => 'btn btn-primary'],
                                'size' => Modal::SIZE_LARGE,
                    ]);
                    ?>

                    <div class="space-1"></div>

                    <p class="text-justify">
                        Para dar cumplimiento a lo previsto en el artículo 10 del Decreto 1377 de 2013, reglamentario de la Ley 1581 de 2012, Copservir Ltda., propietaria de los establecimientos La Rebaja Droguerías y Minimarkets, encargados del tratamiento de los datos personales obtenidos a través de los diferentes canales de comercialización y de la obtención de la tarjeta más, solicitamos a los titulares (clientes) autorización para iniciar o continuar con el tratamiento de sus datos personales, de acuerdo a lo establecido en las Políticas de Privacidad y Protección de los datos publicada en  <a href="http://tarjetamaslarebaja.com" target="_BLANK">www.tarjetamaslarebaja.com</a>.
                        <br>
                        <br>
                        La información y datos personales suministrados podrán ser procesados, recolectados, almacenados, usados, circulados, suprimidos, compartidos, actualizados, transmitidos y/o transferidos total o parcialmente a los establecimientos de La Rebaja Droguerías y Minimarkets, aliados comerciales estratégicos con fines comerciales, administrativos y de mercadeo, incluyendo datos sensibles, de acuerdo con los términos y condiciones de las Políticas de Privacidad 
                        publicadas en <a href="http://tarjetamaslarebaja.com" target="_BLANK">www.tarjetamaslarebaja.com</a> según sean aplicables, principalmente para hacer posible la prestación de sus servicios, para los registros contables que sean requeridos, para reportes a autoridades de control y vigilancia, para el control de los descuentos otorgados y además el uso para fines administrativos, comerciales y de publicidad y contacto frente a los titulares (clientes) de los mismos.
                        <br>
                        <br>
                        De conformidad con los procedimientos contenidos en la Ley 1581 de 2012 y el Decreto 1377 de 2013, los Titulares (clientes) podrán ejercer sus derechos de conocer, actualizar, rectificar y suprimir sus datos personales enviando su solicitud a través del servicio PQRS en la sección Contáctenos de <a href="http://tarjetamaslarebaja.com" target="_BLANK">www.tarjetamaslarebaja.com</a> o llamando a la línea gratuita 01 8000 93 99 00.    
                    </p>
                    <h2>Política general de privacidad y tratamiento de datos personales</h2>
                    <p class="text-justify">
                        Este documento enuncia a la política de privacidad y confidencialidad del  tarjeta más y el sitio web <a href="http://tarjetamaslarebaja.com" target="_BLANK">www.tarjetamaslarebaja.com</a>  dicha política establece que datos se obtienen de los usuarios que adquieren la tarjeta más y que visitan este sitio; la manera en que se protege la información personal que el usuario proporciona y también le permite conocer cómo se procesa y utiliza esta información.  
                    </p> 
                    <p class="text-justify">
                        <strong>Copservir Ltda.</strong>, propietaria de los establecimientos comerciales <strong>La Rebaja Droguerías y Minimarkets</strong> se compromete a garantizar que la privacidad del usuario será protegida cuando visite este sitio. Si por alguna razón, le solicitamos a un usuario que proporcione cierta información será para poder identificarlo y así brindarle el servicio que solicite, puede estar seguro que la información es manejada de acuerdo lo establecido en la Ley 1581 de protección de datos personales de 2012, Decreto 1377 de 2013 y Decreto 886 de 2014.   
                    </p> 
                    <p class="text-justify">
                        <strong>Protección, seguridad y confidencialidad de la información</strong> <br>
                        De conformidad con principios rectores de la Ley estatutaria 1581 de 2012 estamos comprometidos a asegurar que la información personal del usuario esté protegida. Con el fin de evitar el acceso no autorizado o divulgación, se cuenta con la infraestructura física e informática, así como los procedimientos administrativos apropiados para salvaguardar y asegurar la información que recopilamos en línea.    
                    </p> 
                    <p class="text-justify">
                        Los terceros contratados por Copservir Ltda., están igualmente obligados a adherirse y dar cumplimiento a esta política de privacidad, así como a los protocolos de seguridad que aplicamos a todos nuestros procesos y a su vez garantizar la reserva de la información, inclusive después de finalizada su relación con alguna de las labores que comprende el tratamiento. 
                    </p> 
                    <strong class="text-justify">Declaración sobre  la prestación del servicio. </strong>
                    <p class="text-justify">
                        La prestación del servicio de El portal por parte de COPSERVIR tiene carácter gratuito para EL USUARIO y no REQUIERE suscripción o registro de EL USUARIO. No obstante, el empleo  de los  Servicios sólo puede hacerse mediante suscripción o registro de EL USUARIO, de la forma en que se indica expresamente en las correspondientes Condiciones Particulares. 
                    </p>
                    <p class="text-justify">EL USUARIO se obliga a usar el contenido del Portal de forma correcta y lícita. En particular, EL USUARIO se compromete a abstenerse de: (a) utilizar el Contenido del Portal, con fines o efectos contrarios a la ley, a la moral y a las buenas costumbres generalmente aceptadas o al orden público; (b) reproducir o copiar, distribuir, permitir el acceso del público a través de cualquier modalidad de comunicación pública, transformar, modificar o eliminar el Contenido del portal; (c) suprimir, eludir o manipular el Copyright o los derechos de autor y demás datos identificativos de los derechos de COPSERVIR o de los terceros citados como propietarios de los mismos y las respectivas firmas digitales, si fuere el caso; (d) emplear el contenido y, en particular, la información de cualquier clase obtenida a través del Portal o usar los servicios para remitir publicidad, comunicaciones con fines de venta directa o con cualquier otra clase de finalidad comercial, mensajes no solicitados dirigidos a una pluralidad de personas con independencia de su finalidad, así como comercializar o divulgar de cualquier modo dicha información.</p>

                    <p class="text-justify">
                        La información, el software, los productos y los servicios contenidos en El portal pueden contener errores de los cuales no se hacen responsables ni COPSERVIR y/o sus proveedores, a no ser que la distribución del Software se haga a título oneroso. Para utilizar algunos de los Servicios, EL USUARIO proporcionará previamente a COPSERVIR ciertos datos de carácter personal (en adelante, los "Datos Personales"). COPSERVIR tratará mediante procesos automatizados los Datos Personales con las finalidades y bajo las condiciones definidas en su Política de Protección de datos.
                    </p>

                    <strong class="text-justify">Declaración del límite de responsabilidad</strong>
                    <p class="text-justify">
                        <strong>Sobre la disponibilidad del servicio:</strong> Los responsables de este sitio web se comprometen a hacer todo lo posible para tenerlo siempre disponible al público, sin embargo no nos hacemos responsables de problemas técnicos fuera de nuestro control que ocasione fallas temporales.<br>
                        Copservir Ltda., propietaria de los establecimientos comerciales La Rebaja Droguerías y Minimarkets se reserva el derecho de realizar actualizaciones a esta declaración del límite de responsabilidad por lo que le recomendamos revisar este documento periódicamente para estar enterado de estos cambios. 
                    </p>
                    <strong class="text-justify"></strong>
                    <ul class="text-justify">
                        <li>Información técnica del equipo con que accede al sitio web. </li>
                        <li>Información estadística de la navegación del usuario por el sitio web (cedula y contraseña, archivos del sitio solicitados, palabras claves utilizadas en motores de búsqueda, etc.)</li>
                        <li>Información para registrarse en tarjeta más (nombre, cedula, teléfono fijo, celular, correo electrónico, ciudad, dirección, barrio.)</li>
                        <li>Información pertinente para la consulta de descuentos utilizados y disponibles y fecha de vigencia de tarjeta más, para el uso de encuestas o sondeos de opinión (nombre, cedula, teléfonos, correo electrónico).</li>
                        <li>Participación en actividades comerciales como sorteos, rifas, descuentos o cualquier mecanismo de incentivo (nombre, cedula, teléfonos, correo electrónico, ciudad, dirección, barrio, fotos (opcional), mensaje (opcional).</li>
                        <li>Registro de un caso a través del sistema  PQRS (nombre, cedula, teléfonos, correo electrónico, ciudad, descripción del caso). </li>
                    </ul>  
                    <strong class="text-justify">Información que se publica en este sitio</strong>   
                    <ul>
                        <li>Información personal sobre los descuentos utilizados (nombres, cedula, tarjetas asignadas, punto de venta, valor de compra, descuentos otorgados, descuentos disponibles) </li>
                        <li>Información personal sobre el seguimiento a los casos reportados a través del sistema  pqrs (nombre, cedula, teléfonos, correo electrónico, ciudad, descripción del caso, numero de caso y respuesta al caso).</li>
                    </ul>
                    <strong class="text-justify">La información recolectada se emplea para:</strong>   
                    <ul>
                        <li>Utilizar la información suministrada por los usuarios a través de las encuestas o del sistema pqrs para mejorar los servicios que se ofrecen a través de nuestros diferentes canales de comercialización.</li>
                        <li>Suministrar información valiosa al usuario que le permita tener un mayor conocimiento sobre temas de salud, belleza y bienestar integral. </li>
                    </ul> 
                    <p class="text-justify">
                        <strong> Exclusión de Garantías y Exoneración de Responsabilidad.</strong> COPSERVIR  no garantiza la disponibilidad y continuidad del funcionamiento de El portal y de los Servicios. Cuando ello sea razonablemente posible, COPSERVIR advertirá previamente las interrupciones en el funcionamiento de El portal y de los Servicios. COPSERVIR tampoco garantiza la utilidad de El portal y de los Servicios para la realización de alguna actividad en particular, ni su infalibilidad y, en particular, aunque no de modo exclusivo, que EL USUARIO pueda efectivamente utilizar El portal y los Servicios, acceder a las distintas páginas web que forman El portal o a aquellas desde las que se prestan los Servicios.
                    </p>   
                    <ul>
                        <li>COPSERVIR no asume responsabilidad alguna por los daños y perjuicios de toda naturaleza que puedan derivarse de la falta de disponibilidad o de continuidad del funcionamiento de El portal y de los servicios, de la falta de utilidad que EL USUARIO hubiere podido atribuir al Portal y a los servicios, a la fiabilidad de El portal y de los servicios y, en particular, aunque no de modo exclusivo, a las fallas en el acceso a las distintas páginas web de El portal o a aquellas desde las que se prestan los servicios. Lo anterior, debido a que todo servicio prestado a través de la INTERNET utiliza la infraestructura pública de comunicaciones, cuyo control y responsabilidad no están radicados en ningún momento en COPSERVIR.</li>
                    </ul>  


                    <?php $modal::end(); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="space-2"></div>
    <div class="space-2"></div>
</div>
