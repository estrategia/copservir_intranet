<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\intranet\models\MenuPortales;
?>

<div class="modal fade" id="widget-submenu-portal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          Selecciona la opcion que sera el padre
        </h4>
      </div>
      <div class="modal-body">
        <div class="just-padding">
          <div class="list-group list-group-root well">
              <?= MenuPortales::construirMenuModal($idPortal) ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
