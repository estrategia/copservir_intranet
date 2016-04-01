<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<!-- PLANTILLA -->
<div class="row">
  <div class="col-md-8">
    <div class=" tiles white col-md-12 no-padding">
      <div class="tiles green cover-pic-wrapper">
        <div class="overlayer bottom-right">
          <div class="overlayer-wrapper">
              <div class="padding-10 hidden-xs">
                <?php
                $form = ActiveForm::begin([
                            "method" => "post",
                            "enableClientValidation" => true,
                            "options" => ["enctype" => "multipart/form-data"],
                ]);
                ?>
                <?= $form->field($modelFoto, "imagenPerfil")->fileInput(['multiple' => false ]) ?>
                <?= Html::submitButton("Cambiar foto de perfil", ["class" => "btn btn-primary btn-small"]) ?>

                <?= Html::a('Cambiar fondo', ['#'], ['class' => 'btn btn-primary btn-small']) ?>
                <?php $form->end() ?>

                <!--<button type="button" class="btn btn-primary btn-small"><i class="fa fa-check"></i>&nbsp;&nbsp;Cambiar foto de perfil</button> <button type="button" class="btn btn-primary btn-small">Cambiar fondo</button>-->
              </div>
            </div>
        </div>

      <img src="<?= Yii::$app->homeUrl . 'img/cover_pic.png' ?>" alt="">
      </div>
      <div class="tiles white">

        <div class="row">
          <div class="col-md-3 col-sm-3" >
            <div class="user-profile-pic">
              <img width="69" height="69" data-src-retina=""   data-src="" src="<?= Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->imagenPerfil ?>"  alt="">
            </div>
             <div class="user-mini-description">
              <h3 class="text-success semi-bold">
              2548
              </h3>
              <h5>Seguidores</h5>
              <h3 class="text-success semi-bold">
              457
              </h3>
              <h5>Seguidos</h5>
            </div>
          </div>
          <div class="col-md-5 user-description-box  col-sm-5">
            <h4 class="semi-bold no-margin"><?= Yii::$app->user->identity->alias ?></h4>
            <h6 class="no-margin"><?= \Yii::$app->user->identity->getProfesion() ?></h6>
            <br>
            <p><i class="fa fa-briefcase"></i> <?= \Yii::$app->user->identity->getCargo() ?></p>
            <p><i class="fa fa-globe"></i>www.google.com</p>
            <p><i class="fa fa-file-o"></i>Download Resume</p>
            <p><i class="fa fa-envelope"></i>Send Message</p>
          </div>
          <div class="col-md-3  col-sm-3">
            <h5 class="normal">Circulos ( <span class="text-success">1223</span> )</h5>
            <ul class="my-friends">
              <li><div class="profile-pic">
                <img width="35" height="35" data-src-retina="" data-src="assets/img/profiles/d.jpg" src="assets/img/profiles/d.jpg" alt="">
                </div>
              </li>
              <li><div class="profile-pic">
                <img width="35" height="35" data-src-retina="assets/img/profiles/c2x.jpg" data-src="assets/img/profiles/c.jpg" src="assets/img/profiles/c.jpg" alt="">
                </div>
              </li>
              <li><div class="profile-pic">
                <img width="35" height="35" data-src-retina="assets/img/profiles/h2x.jpg" data-src="assets/img/profiles/h.jpg" src="assets/img/profiles/h.jpg" alt="">
                </div>
              </li>
              <li><div class="profile-pic">
                <img width="35" height="35" data-src-retina="assets/img/profiles/avatar_small2x.jpg" data-src="assets/img/profiles/avatar_small.jpg" src="assets/img/profiles/avatar_small.jpg" alt="">
                </div>
              </li>
              <li><div class="profile-pic">
                <img width="35" height="35" data-src-retina="assets/img/profiles/e2x.jpg" data-src="assets/img/profiles/e.jpg" src="assets/img/profiles/e.jpg" alt="">
                </div>
              </li>
              <li><div class="profile-pic">
                <img width="35" height="35" data-src-retina="assets/img/profiles/b2x.jpg" data-src="assets/img/profiles/b.jpg" src="assets/img/profiles/b.jpg" alt="">
                </div>
              </li>
              <li><div class="profile-pic">
                <img width="35" height="35" data-src-retina="assets/img/profiles/h2x.jpg" data-src="assets/img/profiles/h.jpg" src="assets/img/profiles/h.jpg" alt="">
                </div>
              </li>
              <li><div class="profile-pic">
                <img width="35" height="35" data-src-retina="" data-src="assets/img/profiles/d.jpg" src="assets/img/profiles/d.jpg" alt="">
                </div>
              </li>
            </ul>
            <div class="clearfix">
            </div>

          </div>
        </div>

      <div class="tiles-body">
      <div class="row">
      <div class="post col-md-12">
        <div class="info-wrapper">
          <div class="post col-md-5">
            <h5>Información General</h5>
            <p><b>Profesion: </b> <?= \Yii::$app->user->identity->getProfesion() ?></p>
            <p><b>Cargo: </b> <?= \Yii::$app->user->identity->getCargo() ?></p>
            <p><b>Area:</b> <?= \Yii::$app->user->identity->getArea() ?></p>
            <p><b>Vinculacion: </b> <?= \Yii::$app->user->identity->getVinculacion() ?></p>
            <p><b>Antiguedad: </b> <?= \Yii::$app->user->identity->getAntiguedad() ?></p>
            <p><b>Jefe inmediato: </b> <?= \Yii::$app->user->identity->getJefeInmediato() ?></p>
          </div>
          <div class="col-md-5">
            <h5>Educación</h5>
            <p><b>Superiores: </b> <?= \Yii::$app->user->identity->getSuperiores() ?></p>
            <h5>Otra Informacion</h5>
            <p><b>Extencion: </b> <?= \Yii::$app->user->identity->getExtension() ?></p>
            <p><b>E-mail: </b> <?= \Yii::$app->user->identity->getEmail() ?></p>
            <p><b>Celular: </b> <?= \Yii::$app->user->identity->getCelular() ?></p>
            <p><b>Residencia: </b> <?= \Yii::$app->user->identity->getResidencia() ?></p>
            <p><b>Ciudad: </b> <?= \Yii::$app->user->identity->getCiudad() ?></p>
            <p><b>Cumpleaños: </b> <?= \Yii::$app->user->identity->getCumpleanhos() ?></p>
          </div>
          <div class="col-md-2">
            <?= Html::a('Actualizar datos', ['usuario/actualizar-datos'], ['class' => 'btn btn-primary btn-small', 'name' => 'forgot-button']) ?>
            <?= Html::a('Cambiar contraseña', ['usuario/cambiar-clave'], ['class' => 'btn btn-primary btn-small', 'name' => 'forgot-button']) ?>
          </div>


        </div>
        <div class="clearfix"></div>
        <br>
        <br>
      </div>
    </div>
    </div>
      </div>
    </div>
  </div>


  <div class="col-md-4">
    <br>
    <div class="row">
      <div class="col-md-12 no-padding">
      <div class="tiles white">
        <textarea rows="3"  class="form-control user-status-box post-input"  placeholder="Que deseas publicar?"></textarea>

        <!-- aqui desplegables publicacion -->
        <?php //Html::activeDropDownList($modelFoto, 's_id', ArrayHelper::map(Usuario::find()->all(), 's_id', 'name')) ?>

      </div>
      <div class="tiles grey padding-10">
      <div class="pull-left">
        <button class="btn btn-default btn-sm btn-small" type="button"><i class="fa fa-camera"></i></button>
        <!--<button class="btn btn-default btn-sm btn-small" type="button"><i class="fa fa-map-marker"></i></button>-->
      </div>
      <div class="pull-right">
        <button class="btn btn-primary btn-sm btn-small" type="button">publicar</button>
      </div>
      <div class="clearfix"></div>
      </div>
      </div>
    </div>
    <br>
    <br>
  </div>
</div>
<!-- END PLANTILLA -->