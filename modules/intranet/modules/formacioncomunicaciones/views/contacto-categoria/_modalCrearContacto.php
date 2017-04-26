<?php 
use kartik\select2\Select2;
?>

<div id="modal-agregar-contacto-categoria" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar contacto</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <?php 
            echo '<label class="control-label">Usuarios</label>';
            echo Select2::widget([
              'id' => 'selector-usuarios-contacto',
              'name' => 'numeroDocumento',
              'data' => $usuarios,
              'options' => ['placeholder' => 'Seleccione un usuario ...'],
              'pluginOptions' => [
                  'allowClear' => true
              ],
              'hideSearch' => false,
            ]); 
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-role='crear-contacto-categoria'>Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->