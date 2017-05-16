<?php

use yii\helpers\Html;
?>

  <?php foreach ($roles as $rol): ?>
  <div class="grid simple">
    <div class="grid-title no-border" style="background-color:#367FA9 !important;">
      <h4 style='color:#fff !important;'>
        Rol:
        <span class="semi-bold"><?= Html::encode($rol->name) ?></span>
      </h4>

      <div class="tools">
          <a href="javascript:;" class="collapse"></a>
      </div>
    </div>
    <div class="grid-body no-border">
      <table class="table no-more-tables">
        <thead>
          <tr>
            <th>Permiso</th>
            <th>Descripcion</th>
          </tr>
        </thead>
        <tbody>
          <?php $permisos =  Yii::$app->authManager->getPermissionsByRole($rol->name) ?>
          <?php foreach ($permisos as $permiso): ?>
            <tr>
              <td><?= Html::encode($permiso->name) ?></td>
              <td><?= Html::encode($permiso->description) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endforeach; ?>
