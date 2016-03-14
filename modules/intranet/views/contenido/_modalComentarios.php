<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>


<div class="modal fade" id="modal-comentarios-contenido" tabindex="-1" with='700px' role="dialog">
    
    <div class="modal-dialog" role="document" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Listado de comentarios </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <!-- listado de me gusta's -->
                <!--  <div class="grid-body no-border">
                      <table class="table table-hover no-more-tables">
                          <tbody> -->

                <?php foreach ($comentariosContenido as $comentario): ?>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="user-profile">
                                <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $comentario->objUsuarioPublicacionComentario->imagenPerfil ?> alt="" data-src="" data-src-retina="" width="40" height="40">
                            </div>
                            <?= $comentario->objUsuarioPublicacionComentario->alias ?>
                        </div>
                        <div class="col-md-10">

                            <?= $comentario->contenido ?>
                        </div>
                    </div>  
                <?php endforeach; ?>
                <!-- </tbody>
            </table> 
        </div>-->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>
