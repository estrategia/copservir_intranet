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
                        <div class="col-md-2">
                          <div class="user-profile">
                              <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $meGusta->objUsuario->imagenPerfil ?> alt="" data-src="" data-src-retina="" width="40" height="40">
                          </div>
                            <?= $meGusta->objUsuario->alias ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
