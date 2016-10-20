<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = $model->numeroDocumento;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Proveedor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form  name="permisos" id="permisos" action=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/permisos' ?> " method="POST" >
        <?php foreach ($permisos as $permiso): ?>
            <label>
              <input type="checkbox" name="<?= $permiso['rol'] ?>" value=" <?= $permiso['rol'] ?> ">
              <?= $permiso['nombre']; ?>
            </label>
        <?php endforeach; ?>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <input type="submit" value="Guardar">
      </form>
    </div>
</div>
