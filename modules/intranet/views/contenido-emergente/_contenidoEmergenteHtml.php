<div class="modal fade" id="widget-popup" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">&nbsp;</h4>
      </div>
      <div class="modal-body">
        <?= $query['contenido'] ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" data-role='inactiva-popup' data-contenido="<?= $query['idContenidoEmergente'] ?>" class="btn btn-primary">ocultar</button>
      </div>
    </div>
  </div>
</div>
