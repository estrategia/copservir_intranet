<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;


$data = $usuario;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perfil de usuario')];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $data['personal']['nombres'])];
?>


<?= $this->render('/common/errores', []) ?>


<div class="row">
  <div class="col-md-12">
    <div class=" tiles white col-md-12 no-padding">
      <div class="tiles grey cover-pic-wrapper">
        <img class="ajustada" src="" alt="">
      </div>
      <div class="tiles white">

        <div class="row">
          <div class="col-md-3 col-sm-3" >
            <div class="user-profile-pic">
              <img width="69" height="69" data-src-retina=""   data-src="" src=" <?= $imagenPerfil ?> "  alt="">
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
            <h4 class="semi-bold no-margin"><?= $data['personal']['nombres'] ?></h4>
            <br>
            <p><i class="fa fa-briefcase"></i> <?= $data['personal']['nombres'] ?></p>
          </div>
          <div class="col-md-3  col-sm-3">
            <h5 class="normal">Grupos ( <span class="text-success"><?= count($gruposReferencia) ?></span> )</h5>
            <ul class="my-friends">
              <?php foreach ($gruposReferencia as $grupo): ?>
                <li>
                  <div class="profile-pic">
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
              <div class="post col-md-5 col-md-offset-1">
                <h5>Informaci&oacute;n General</h5>
                <p><b>Nombre: </b> <?= $usuario['personal']['nombres'].' '.$usuario['personal']['primerApellido'].' '.$usuario['personal']['segundoApellido'] ?></p>
                <p><b>Cargo: </b> <?= $usuario['laboral']['cargo']['nombre'] ?></p>
                <p><b>Vinculaci&oacute;n: </b> <?= $usuario['laboral']['fechaVinculacion'] ?></p>
              </div>
              <div class="post col-md-5">
                <h5>Otra Informaci&oacute;n</h5>
                <p><b>E-mail: </b> <?= $usuario['laboral']['correoElectronico'] ?></p>
                <p><b>E-mail Personal: </b> <?= $usuario['personal']['correoPersonal'] ?></p>
                <p><b>N&uacute;meros Telefonicos: </b> <?= $usuario['personal']['celular'] ?></p>
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
