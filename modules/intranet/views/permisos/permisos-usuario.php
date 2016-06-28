<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;

$this->title = 'Roles y permisos de un usuario';
$this->params['breadcrumbs'][] = ['label' => 'Permisos de usuarios', 'url'=>['/intranet/permisos/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Administrar permisos'];
?>
<div class="row">
<div class="col-md-4">
  <!--foto usuario -->
  <img src="<?= Yii::getAlias('@web').'/img/fotosperfil/'. $usuario->imagenPerfil ?>" class="img-circle img-responsive" style="width: 20%;"/>
</div>
<div class="col-md-8">
  <!-- informacion del usuario -->
  <h4>
    <?= Html::encode($usuario->alias) ?>
  </h4>
</div>
</div>
  <br>
  <br>
  <br>
<div class="row">
  <div class="col-md-12">
    <h4>asigne un nuevo rol</h4>
    <!-- formulario para asignar permiso -->
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
      <?php
        echo $form->field($autAssignment, 'item_name')->widget(Select2::classname(), [
          'data' => $autAssignment->getListaRoles($usuario->numeroDocumento),
          'options' => ['placeholder' => 'Seleccione un rol', 'onchange' => ' $( "#lista-permisos" ).empty(); getListaPermisos($(this).val())'],
          'pluginEvents' => [
                            ],
          'pluginOptions' => [
              'allowClear' => true,
          ],
        ])->label(false);
      ?>

      <?= $form->field($autAssignment, 'user_id')->hiddenInput(['value'=> $usuario->numeroDocumento])->label(false); ?>

    </div>
    <div class="col-md-6">
      <div class="form-group">
        <?= Html::submitButton('Asignar rol', ['class' => 'btn btn-primary']) ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
  <div class="col-md-12" id="lista-permisos">

    <!-- permisos del rol q seleccione en le formulario -->
  </div>
</div>

<div class="row">
  <!-- roles y permisos asignados al usuario-->
  <div class="col-md-12">
    <h4>Roles y permisos asignados al  usuario</h4>
    
    <?php foreach ($roles as $rol): ?>
    <div class="grid simple">
      <div class="grid-title no-border" style="background-color:#367FA9 !important;">
        <h4 style='color:#fff !important;'>
          Rol:
          <span class="semi-bold"><?= Html::encode($rol->name) ?></span>
        </h4>

        <div class="tools">

          <?= Html::a('Eliminar', ['eliminar-rol', 'nombreRol' => $rol->name, 'numeroDocumento' => $usuario->numeroDocumento], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
              'confirm' => 'Estas seguro de eliminar este rol al usuario?',
              'method' => 'post',
            ],
            ]) ?>

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

  </div>
</div>
