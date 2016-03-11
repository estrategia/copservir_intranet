<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Tareas';
?>


<div class="col-md-12">


      <a data-toggle="modal" data-target="#modal_formulario_noticias" type="button" class="btn btn-primary btn-lg btn-large"> <i class="fa fa-pencil"></i> Publicar</a>

        <ul class="cbp_tmtimeline">

          <li>
            <time class="cbp_tmtime" datetime="2013-04-10 18:30">
              <span class="date">Mar 08</span>
              <span class="time"><span class="animate-number" data-value="12" data-animation-duration="600">12</span>:<span class="animate-number" data-value="45" data-animation-duration="600">45</span> <span class="semi-bold">pm</span></span>
            </time>
            <div class="cbp_tmicon animated bounceIn">
              <div class="user-profile"> <img src="assets/img/profiles/d.jpg" data-src="assets/img/profiles/d.jpg" data-src-retina="assets/img/profiles/d2x.jpg" width="35" height="35" alt=""> </div>
            </div>
            <div class="cbp_tmlabel">
              <div class="p-t-10 p-l-30 p-r-20 p-b-20 xs-p-r-10 xs-p-l-10 xs-p-t-5">
                <h4 class="inline m-b-5"><span class="text-success semi-bold">Cuida tu Corazón</span> </h4>
                <h5 class="inline muted semi-bold m-b-5">@Lorena_Delgado</h5>
                <div class="muted">Publicación Compartida - 12:45pm</div>
                <p class="m-t-5 dark-text"> Buenas Tardes!, en nombre de la Rebaja Droguería y Minimarkets queremos dar las gracias a los participantes que estuvieron activos en nuestro foro sobre CUIDA TU CORAZON, así como a la especialista Dr.OSCAR DAVID GARCIA GIRALDO - MEDICO Y CIRUJANO UNIVERSIDAD DEL VALLE representando a laboratorios Abbott Lafrancol, que estuvo muy atentO a las preguntas de los foristas. ... </p>
                <a href="#" class="muted">Leer más</a> </div>

              <div class="clearfix"></div>
              <div class="xs-p-r-10 xs-p-l-10 p-l-30 p-r-20 p-b-10 p-t-20 row">
                <div class="col-md-6">
                  <h5 class="inline m-r-10">205 Comentarios</h5>
                  <h5 class="inline">21,586 Les Gusta</h5>
                </div>
                <div class="col-md-6">
                  <ul class="my-friends no-margin pull-right">
                    <li>
                      <div class="profile-pic"> <img width="35" height="35" data-src-retina="assets/img/profiles/e2x.jpg" data-src="assets/img/profiles/e.jpg" src="assets/img/profiles/e.jpg" alt=""> </div>
                    </li>
                    <li>
                      <div class="profile-pic"> <img width="35" height="35" data-src-retina="assets/img/profiles/b2x.jpg" data-src="assets/img/profiles/b.jpg" src="assets/img/profiles/b.jpg" alt=""> </div>
                    </li>
                    <li>
                      <div class="profile-pic"> <img width="35" height="35" data-src-retina="assets/img/profiles/h2x.jpg" data-src="assets/img/profiles/h.jpg" src="assets/img/profiles/h.jpg" alt=""> </div>
                    </li>
                  </ul>
         <div class="clearfix"></div>
                </div>
              </div>
              <div class="tiles grey p-t-10 p-b-10 p-l-20">
                <ul class="action-links">
                  <li>0 Me Gusta</li>
                  <li>0 Comentarios</li>
                </ul>
                <div class="clearfix"></div>
              </div>
            </div>
          </li>


          <li>
            <time class="cbp_tmtime" datetime="2013-04-10 18:30">
              <span class="date">Mar 07</span>
              <span class="time"><span class="animate-number" data-value="12" data-animation-duration="600">12</span>:<span class="animate-number" data-value="45" data-animation-duration="600">45</span> <span class="semi-bold">pm</span></span>
            </time>
            <div class="cbp_tmicon animated bounceIn">
              <div class="user-profile"> <img src="assets/img/profiles/0avatar_small.jpg" data-src="assets/img/profiles/0avatar_small.jpg" data-src-retina="assets/img/profiles/0avatar_small.jpg" width="35" height="35" alt=""> </div>
            </div>
            <div class="cbp_tmlabel">
              <div class="p-t-10 p-l-30 p-r-20 p-b-20 xs-p-r-10 xs-p-l-10 xs-p-t-5">
                <h4 class="inline m-b-5"><span class="text-success semi-bold">Foro Cuidado íntimo de la Mujer</span> </h4>
                <h5 class="inline muted semi-bold m-b-5">@augustog</h5>
                <div class="muted">Publicación Compartida - 12:45pm</div>
                <p class="m-t-5 dark-text">Hoy!Foro Cuidado íntimo de la Mujer! te esperamos! Regístrate http://ow.ly/PZxkV participa http://ow.ly/PZxwQ </p></div>

              <div class="clearfix"></div>
              <div class="xs-p-r-10 xs-p-l-10 p-l-30 p-r-20 p-b-10 p-t-20 row">
                <div class="col-md-6">
                  <h5 class="inline m-r-10">1 Comentarios</h5>
                  <h5 class="inline">20 Les Gusta</h5>
                </div>
                <div class="col-md-6">

         <div class="clearfix"></div>
                </div>
              </div>
              <div class="tiles grey p-t-10 p-b-10 p-l-20">
                <ul class="action-links">
                  <li>0 Me Gusta</li>
                  <li>0 Comentarios</li>
                </ul>
                <div class="clearfix"></div>
              </div>
            </div>
          </li>


          <li>
            <time class="cbp_tmtime" datetime="2013-04-10 18:30">
              <span class="date">Mar 07</span>
              <span class="time"><span class="animate-number" data-value="12" data-animation-duration="600">12</span>:<span class="animate-number" data-value="45" data-animation-duration="600">45</span> <span class="semi-bold">pm</span></span>
            </time>
            <div class="cbp_tmicon animated bounceIn">
              <div class="user-profile"> <img src="assets/img/profiles/c.jpg" data-src="assets/img/profiles/c.jpg" data-src-retina="assets/img/profiles/c.jpg" width="35" height="35" alt=""> </div>
            </div>
            <div class="cbp_tmlabel">
              <div class="p-t-10 p-l-30 p-r-20 p-b-20 xs-p-r-10 xs-p-l-10 xs-p-t-5">
                <h4 class="inline m-b-5"><span class="text-success semi-bold">Miércoles de Mascotas</span> </h4>
                <h5 class="inline muted semi-bold m-b-5">@larebajavirtual</h5>
                <div class="muted">Publicación Compartida - 12:45pm</div>
                <p class="m-t-5 dark-text">‪#‎FelizMiercoles‬!, encuentra productos para tu ‪#‎QueridaMascota‬ en ptos de venta seleccionados <a href="www.larebajavirtual.com " target="_blank">www.larebajavirtual.com </a></p></div>

              <div class="clearfix"></div>
              <div class="xs-p-r-10 xs-p-l-10 p-l-30 p-r-20 p-b-10 p-t-20 row">
                <div class="col-md-6">
                  <h5 class="inline m-r-10">1 Comentarios</h5>
                  <h5 class="inline">20 Les Gusta</h5>
                </div>
                <div class="col-md-6">

         <div class="clearfix"></div>
                </div>
              </div>
              <div class="tiles grey p-t-10 p-b-10 p-l-20">
                <ul class="action-links">
                  <li>0 Me Gusta</li>
                  <li>0 Comentarios</li>
                </ul>
                <div class="clearfix"></div>
              </div>
            </div>
          </li>




        </ul>
      </div>
