<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<!--
<div class="tiles-body">
    <div class="row">
        <div class="info">
            <div class="col-md-6">
                <div class="user-profile-pic">
                    <img width="150" height="150" alt="" src="<?= Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->imagenPerfil ?>" >
                </div>
                <?php
                $form = ActiveForm::begin([
                            "method" => "post",
                            "enableClientValidation" => true,
                            "options" => ["enctype" => "multipart/form-data"],
                ]);
                ?>
                <?= $form->field($modelFoto, "imagenPerfil")->fileInput(['multiple' => false]) ?>
                <?= Html::submitButton("Subir Foto", ["class" => "btn btn-primary btn-sm"]) ?>
                <?php $form->end() ?>

<?= Html::a('Actualizar datos', ['/site/actualizar-datos'], ['class' => 'btn btn-primary btn-sm', 'name' => 'forgot-button']) ?>
<?= Html::a('Cambiar contraseña', ['/site/cambiar-clave'], ['class' => 'btn btn-primary btn-sm', 'name' => 'forgot-button']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="post col-md-12">

            <div class="info-wrapper">

                <div class="info">
                    <div class="post col-md-6">
                        <h5>Información General</h5>
                        <b>Profesión:</b> <?= \Yii::$app->user->identity->getProfesion() ?> <br>
                        <b>Cargo:</b> <?= \Yii::$app->user->identity->getCargo() ?> <br>
                        <b>Area:</b> <?= \Yii::$app->user->identity->getArea() ?> <br>
                        <b>Vinculación:</b> <?= \Date("Y-m-d", \Yii::$app->user->identity->getVinculacion()) ?> <br>
                        <b>Antiguedad:</b> <?= \Yii::$app->user->identity->getAntiguedad() ?> <br>
                        <b>Jefe Inmediato:</b><?= \Yii::$app->user->identity->getJefeInmediato() ?>
                    </div>
                    <div class="post col-md-6">
                        <h5>Educación</h5>
                        <b>Superiores:</b> <?= \Yii::$app->user->identity->getSuperiores() ?>
                        <h5>Otra Información</h5>
                        <b>Extensión:</b> <?= \Yii::$app->user->identity->getExtension() ?><br>
                        <b>eMail:</b> <?= \Yii::$app->user->identity->getEmail() ?><br>
                        <b>Celular:</b> <?= \Yii::$app->user->identity->getCelular() ?><br>
                        <b>Residencia:</b> <?= \Yii::$app->user->identity->getResidencia() ?><br>
                        <b>Ciudad:</b> <?= \Yii::$app->user->identity->getCiudad() ?><br>
                        <b>Cumpleaños:</b> <?= \Yii::$app->user->identity->getCumpleanhos() ?>
                    </div>
                </div>



            </div>
            <div class="clearfix"></div>
            <br>
            <br>
        </div>
    </div>
</div> -->

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
        <!--<div class="user-profile-pic-wrapper">
          <div class="user-profile-pic-normal">
              <img width="35" height="35" data-src-retina="assets/img/profiles/c2x.jpg" data-src="assets/img/profiles/c.jpg" src="assets/img/profiles/c.jpg" alt="">
            </div>
        </div>-->
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
            <?= Html::a('Actualizar datos', ['/site/actualizar-datos'], ['class' => 'btn btn-primary btn-small', 'name' => 'forgot-button']) ?>
            <?= Html::a('Cambiar contraseña', ['/site/cambiar-clave'], ['class' => 'btn btn-primary btn-small', 'name' => 'forgot-button']) ?>
          </div>


        </div>
        <!--<div class="info-wrapper">
          <div class="username">
            <span class="dark-text">John Drake</span> in <span class="dark-text">nervada hotspot</span>
          </div>
          <div class="info">
            Great design concepts by <span class="dark-text">John Smith</span> and his crew! Totally owned the WCG!, Best of luck for your future endeavours,
            Special thanks for <span class="dark-text">Jane smith</span> for her motivation ;)
          </div>
          <div class="more-details">
            <ul class="post-links">
              <li><a href="#" class="muted">2 Minutes ago</a></li>
              <li><a href="#" class="text-info">Collapse</a></li>
              <li><a href="#" class="text-info" ><i class="fa fa-reply"></i> Reply</a></li>
              <li><a href="#" class="text-warning"><i class="fa fa-star"></i> Favourited</a></li>
              <li><a href="#"  class="muted">More</a></li>
            </ul>
          </div>
            <div class="clearfix"></div>

          <ul class="action-bar">
            <li><a href="#"  class="muted"><i class="fa fa-comment"></i> 1584</a> Comments</li>
            <li><a href="#" class="text-error" ><i class="fa fa-heart"></i> 47k</a> likes</li>
          </ul>
          <div class="clearfix"></div>
          <div class="post comments-section">
              <div class="user-profile-pic-wrapper">
                <div class="user-profile-pic-normal">
                    <img width="35" height="35" alt="" src="assets/img/profiles/e.jpg" data-src="assets/img/profiles/e.jpg" data-src-retina="assets/img/profiles/e2x.jpg">
                  </div>
              </div>
              <div class="info-wrapper">
                <div class="username">
                  <span class="dark-text">Thunderbolt</span>
                </div>
                <div class="info">
                  Congrats, <span class="dark-text">John Smith</span>  & <span class="dark-text">Jane Smith</span>
                </div>
                <div class="more-details">
                  <ul class="post-links">
                    <li><a href="#" class="muted">2 Minutes ago</a></li>
                    <li><a href="#" class="text-error" ><i class="fa fa-heart"></i> Like</a></li>
                    <li><a href="#"  class="muted">Details</a></li>
                  </ul>
                </div>

              </div>
              <div class="clearfix"></div>
          </div>
        <div class="post comments-section">
              <div class="user-profile-pic-wrapper">
                <div class="user-profile-pic-normal">
                    <img width="35" height="35" src="assets/img/profiles/h.jpg" data-src="assets/img/profiles/h.jpg" data-src-retina="assets/img/profiles/h2x.jpg" alt="">
                  </div>
              </div>
              <div class="info-wrapper">
                <div class="username">
                  <span class="dark-text">Thunderbolt</span>
                </div>
                <div class="info">
                  Congrats, <span class="dark-text">John Smith</span>  & <span class="dark-text">Jane Smith</span>
                </div>
                <div class="more-details">
                  <ul class="post-links">
                    <li><a href="#" class="muted">2 Minutes ago</a></li>
                    <li><a href="#" class="text-error" ><i class="fa fa-heart"></i> Like</a></li>
                    <li><a href="#"  class="muted">Details</a></li>
                  </ul>
                </div>

              </div>
              <div class="clearfix"></div>
          </div>
        </div> -->
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
    <div class="row">
    <!--<div class="tiles white col-md-12  no-padding">
      <div class="tiles-body">
        <h5 ><span class="semi-bold">You many also know</span>&nbsp;&nbsp; <a href="#" class="text-info normal-text">view more</a></h5>
        <div class="row">
          <div class="col-md-6">
            <div class="friend-list">
              <div class="friend-profile-pic">
                <div class="user-profile-pic-normal">
                <img width="35" height="35" src="assets/img/profiles/d.jpg" data-src="assets/img/profiles/d.jpg" data-src-retina="" alt="">
                </div>
              </div>
              <div class="friend-details-wrapper">
                <div class="friend-name">
                  Johne Drake
                </div>
                <div class="friend-description">
                  James Smith in commman
                </div>
              </div>
              <div class="action-bar pull-right">
                <button class="btn btn-primary" type="button">Add</button>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="friend-list">
              <div class="friend-profile-pic">
                <div class="user-profile-pic-normal">
                <img width="35" height="35" src="assets/img/profiles/b.jpg" data-src="assets/img/profiles/b.jpg" data-src-retina="assets/img/profiles/b2x.jpg" alt="">
                </div>
              </div>
              <div class="friend-details-wrapper">
                <div class="friend-name">
                  Johne Drake
                </div>
                <div class="friend-description">
                  James Smith in commman
                </div>
              </div>
              <div class="action-bar pull-right">
                <button class="btn btn-primary" type="button">Add</button>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </div>-->
    </div>
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
    <br><!--
    <div class="row">
      <div class="post col-md-12">
        <div class="user-profile-pic-wrapper">
          <div class="user-profile-pic-normal">
              <img width="35" height="35" src="assets/img/profiles/c.jpg" data-src="assets/img/profiles/c.jpg" data-src-retina="assets/img/profiles/c2x.jpg" alt="">
            </div>
        </div>
        <div class="info-wrapper">
          <div class="username">
            <span class="dark-text">John Drake</span> in <span class="dark-text">nervada hotspot</span>
          </div>
          <div class="info">
            Great design concepts by <span class="dark-text">John Smith</span> and his crew! Totally owned the WCG!, Best of luck for your future endeavours,
            Special thanks for <span class="dark-text">Jane smith</span> for her motivation ;)
          </div>
          <div class="more-details">
            <ul class="post-links">
              <li><a href="#" class="muted">2 Minutes ago</a></li>
              <li><a href="#" class="text-info">Collapse</a></li>
              <li><a href="#" class="text-info" ><i class="fa fa-reply"></i> Reply</a></li>
              <li><a href="#" class="text-warning"><i class="fa fa-star"></i> Favourited</a></li>
              <li><a href="#"  class="muted">More</a></li>
            </ul>
          </div>
            <div class="clearfix"></div>

          <ul class="action-bar">
            <li><a href="#"  class="muted"><i class="fa fa-comment"></i> 1584</a> Comments</li>
            <li><a href="#" class="text-error" ><i class="fa fa-heart"></i> 47k</a> likes</li>
          </ul>
          <div class="clearfix"></div>
          <div class="post comments-section">
              <div class="user-profile-pic-wrapper">
                <div class="user-profile-pic-normal">
                    <img width="35" height="35" data-src-retina="assets/img/profiles/e2x.jpg" data-src="assets/img/profiles/e.jpg" src="assets/img/profiles/e.jpg" alt="">
                  </div>
              </div>
              <div class="info-wrapper">
                <div class="username">
                  <span class="dark-text">Thunderbolt</span>
                </div>
                <div class="info">
                  Congrats, <span class="dark-text">John Smith</span>  & <span class="dark-text">Jane Smith</span>
                </div>
                <div class="more-details">
                  <ul class="post-links">
                    <li><a href="#" class="muted">2 Minutes ago</a></li>
                    <li><a href="#" class="text-error" ><i class="fa fa-heart"></i> Like</a></li>
                    <li><a href="#"  class="muted">Details</a></li>
                  </ul>
                </div>

              </div>
              <div class="clearfix"></div>
          </div>
        <div class="post comments-section">
              <div class="user-profile-pic-wrapper">
                <div class="user-profile-pic-normal">
                    <img width="35" height="35" data-src-retina="assets/img/profiles/b2x.jpg" data-src="assets/img/profiles/b.jpg" src="assets/img/profiles/b.jpg" alt="">
                  </div>
              </div>
              <div class="info-wrapper">
                <div class="username">
                  <span class="dark-text">Thunderbolt</span>
                </div>
                <div class="info">
                  Congrats, <span class="dark-text">John Smith</span>  & <span class="dark-text">Jane Smith</span>
                </div>
                <div class="more-details">
                  <ul class="post-links">
                    <li><a href="#" class="muted">2 Minutes ago</a></li>
                    <li><a href="#" class="text-error" ><i class="fa fa-heart"></i> Like</a></li>
                    <li><a href="#"  class="muted">Details</a></li>
                  </ul>
                </div>

              </div>
              <div class="clearfix"></div>
          </div>
          <div class="post comments-section">

          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>-->
  </div>
</div>
<!-- END PLANTILLA -->
