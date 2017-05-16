<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;

?>
<div class="modal fade" id="widget-traza" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          Historial de cambios de estado
        </h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" style="background-color: white;">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Premio</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($redenciones as $redencion): ?>
              <tr>
                <td>
                  <?php echo $redencion['fechaRegistro']; ?>
                </td>
                <td>
                  <?php echo $redencion['nombrePremio']; ?>
                </td>
                <td>
                  <?php 
                    if ($redencion['estado'] == 1) {
                        echo 'Pendiente';
                    } elseif ($redencion['estado'] == 2) {
                        echo 'Tramitado';
                    } elseif ($redencion['estado'] == 3) {
                        echo 'Cancelado';
                    }
                  ?>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>