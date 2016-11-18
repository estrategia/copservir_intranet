<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="modal fade" id="modal-me-gusta-contenido" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Personas que les gusta esto </h4>
      </div>

      <div class="modal-body">

        <div class="row">
          <?php foreach ($usuariosMeGusta as $meGusta): ?>
            <!--
            <div class="col-md-2">
              <center>
                <div class="notification-messages">

                  <div class="user-profile">
                    <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $meGusta->objUsuario->getImagenPerfil() ?> alt=""
                    data-src="" data-src-retina="" width="40" height="40">
                  </div>

                  <div class="message-wrapper">
                    <div class="heading">
                        <?= $meGusta->objUsuario->alias ?>
                    </div>
                    <div class="description"></div>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </center>

            </div>
            -->
            <center>
              <div class="col-md-12">


            <div class="tiles white ">
                <div class="p-t-20 p-b-15 b-b b-grey">
                  <div class="post overlap-left-10">

                    <div class="user-profile-pic-wrapper">
                      <div class="user-profile-pic-2x white-border">
                        <div class="user-profile">
                          <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $meGusta->objUsuario->getImagenPerfil() ?> alt=""
                          data-src="" data-src-retina="" width="40" height="40">
                        </div>
                      </div>
                    </div>

                    <div class="info-wrapper small-width inline">
                      <div class="info text-black ">
                        <p>
                          <?= $meGusta->objUsuario->alias ?>
                        </p>
                      </div>
                      <div class="clearfix"></div>
                    </div>

                    <div class="clearfix"></div>
                  </div>
                </div>
            </div>
          </div>
        </center>

          <?php endforeach; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
