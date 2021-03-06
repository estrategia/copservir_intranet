<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="modal fade" id="modal-comentarios-contenido" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 style="display:inline-block;" class="modal-title">Listado de comentarios </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body" id='comentarios_contenido'>
        <?php echo $this->render('_listadoComentarios',['comentariosContenido' => $comentariosContenido]);?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
