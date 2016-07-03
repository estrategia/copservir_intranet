<?php

use yii\helpers\Html;
?>

<!-- PLANTILLA -->
<div class="row">
  <div class="col-md-12">
    <div class=" tiles white col-md-12 no-padding">
      <div class="tiles grey cover-pic-wrapper">
        <img class="ajustada" src="<?= Yii::$app->homeUrl . 'img/imagenesFondo/' . \Yii::$app->user->identity->imagenFondo ?>" alt="">
      </div>
      <div class="tiles white">

        <div class="row">
          <div class="col-md-3 col-sm-3" >
            <div class="user-profile-pic">
              <img width="69" height="69" data-src-retina=""   data-src="" src="<?= Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->imagenPerfil ?>"  alt="">
            </div>
            <div class="user-mini-description">
              <h3 class="text-success semi-bold">
                <?= $contenidos ?>
              </h3>
              <h5>Publicaciones realizadas</h5>
              <h3 class="text-success semi-bold">
                <?= $meGustan ?>
              </h3>
              <h5>Me gusta</h5>
            </div>
          </div>
          <div class="col-md-5 user-description-box  col-sm-5">
            <h4 class="semi-bold no-margin"><?= Yii::$app->user->identity->alias ?></h4>
            <h6 class="no-margin"><?= \Yii::$app->user->identity->getProfesion() ?></h6>
            <br>
            <p><i class="fa fa-briefcase"></i> <?= \Yii::$app->user->identity->getCargoNombre() ?></p>
          </div>
          <div class="col-md-3  col-sm-3">
            <h5 class="normal">Grupos ( <span class="text-success"><?= count($gruposReferencia) ?></span> )</h5>
            <ul class="my-friends">
              <?php foreach ($gruposReferencia as $grupo): ?>
                <li><div class="profile-pic">
                  <img width="35" height="35" data-src-retina="" data-src="<?= $grupo->getImagen() ?>" src="<?= $grupo->getImagen() ?>" title="<?= $grupo->nombreGrupo ?>" alt="">
                </div>
              </li>
            <?php endforeach; ?>
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
                <h5>Informaci&oacute;n General</h5>
                <p><b>nombre: </b> <?= \Yii::$app->user->identity->getNombres().' '.\Yii::$app->user->identity->getPrimerApellido().' '.\Yii::$app->user->identity->getSegundoApellido() ?></p>
                <p><b>Profesi&oacute;n: </b> <?= \Yii::$app->user->identity->getProfesion() ?></p>
                <p><b>Cargo: </b> <?= \Yii::$app->user->identity->getCargoNombre() ?></p>
                <p><b>&Aacute;rea:</b> <?= \Yii::$app->user->identity->getAreaNombre() ?></p>
                <p><b>Vinculaci&oacute;n: </b> <?= \Yii::$app->user->identity->getVinculacion() ?></p>
                <p><b>Antiguedad: </b> <?= \Yii::$app->user->identity->getAntiguedad() ?></p>
                <p><b>Jefe inmediato: </b> <?= \Yii::$app->user->identity->getJefeInmediatoNombre() ?></p>
              </div>
              <div class="col-md-5">
                <h5>Educación</h5>
                <p><b>Superiores: </b> <?= \Yii::$app->user->identity->getEstudiosSuperiores() ?></p>
                <h5>Otra Informaci&oacute;n</h5>
                <p><b>Extensi&oacute;n: </b> <?= \Yii::$app->user->identity->getExtension() ?></p>
                <p><b>E-mail: </b> <?= \Yii::$app->user->identity->getEmail() ?></p>
                <p><b>E-mail Personal: </b> <?= \Yii::$app->user->identity->getEmailPersonal() ?></p>
                <p><b>Números Telefonicos: </b> <?= \Yii::$app->user->identity->getCelular() ?></p>
                <p><b>Residencia: </b> <?= \Yii::$app->user->identity->getResidencia() ?></p>
                <p><b>Ciudad: </b> <?= \Yii::$app->user->identity->getCiudadNombre() ?></p>
                <p><b>Cumplea&ntilde;os: </b> <?= \Yii::$app->user->identity->getCumpleanhos() ?></p>
              </div>
              <div class="col-md-2">
                <?php //echo Html::a('Actualizar datos', ['usuario/actualizar-datos'], ['class' => 'btn btn-primary btn-small', 'name' => 'update-button']) ?>
                <div style="height: 5px"></div>
                <?= Html::a('Cambiar contraseña', ['usuario/cambiar-clave'], ['class' => 'btn btn-primary btn-small', 'name' => 'password-button']) ?>
                <div style="height: 5px"></div>
                <?= Html::a('Cambiar fotos', ['usuario/cambiar-foto-perfil'], ['class' => 'btn btn-primary btn-small', 'name' => 'picture-button']) ?>
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

      <div class="overlayer-wrapper">
        <div class="padding-10 hidden-xs">
        </div>
      </div>
    </div>

  </div>
</div>
<br>
<br>
</div>
</div>
<!-- END PLANTILLA -->
