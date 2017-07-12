<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;

?>
<div class="modal fade" id="widget-puntos-usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          Puntos
        </h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" style="background-color: white;">
          <thead>
            <tr>
              <th>Concepto</th>
              <th>Valor</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Cumpleaños</td>
              <td><?= $puntos[1] ?></td>
            </tr>
            <tr>
              <td>Aniversarios</td>
              <td><?= $puntos[2] ?></td>
            </tr>
            <tr>
              <td>Contenidos</td>
              <td><?= $puntos[3] ?></td>
            </tr>
            <tr>
              <td>Cursos</td>
              <td><?= $puntos[4] ?></td>
            </tr>
            <tr>
              <td>Externos</td>
              <td><?= $puntos[999] ?></td>
            </tr>
            <tr>
              <td>Sin redimir</td>
              <td><?= $puntos['totales'] != 0 ? $puntos['totales']->puntos : $puntos['totales'] ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>