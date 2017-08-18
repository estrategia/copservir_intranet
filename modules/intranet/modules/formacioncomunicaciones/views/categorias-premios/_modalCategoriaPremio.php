<div class="modal fade" id="modal-asignar-categoria-premio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          Asignar Categoría Padre
        </h4>
      </div>
      <div class="modal-body">
        <div class="just-padding">
          <div class="list-group list-group-root well">
            <?php foreach ($categorias as $key => $padre): ?>
              <div class="list-group-item" data-toggle="collapse" data-target="<?= '#padre' . $padre->idCategoria ?>" >
                <i class="glyphicon glyphicon-chevron-right"></i>
                <?= $padre->nombreCategoria ?>
                
              </div>
              <div id="<?= 'padre'. $padre->idCategoria ?>" class="list-group collapse">
                <?php foreach ($padre->categoriasPremios as $key => $hijo): ?>
                  <div class="list-group-item" data-toggle="collapse" data-target="<?= '#hijo' . $hijo->idCategoria ?>" >
                    <i class="glyphicon glyphicon-minus"></i>    
                    <?= $hijo->nombreCategoria ?>
                    <a href="#" class="btn btn-small" style="float:right;" data-role="categoria-premio-asignar" data-id-categoria="<?= $hijo->idCategoria ?>" data-nombre-categoria="<?= $hijo->nombreCategoria ?>">Asignar</a>
                  </div>
                <?php endforeach ?>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
