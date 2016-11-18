<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = $model->numeroDocumento;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Proveedor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->numeroDocumento], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numeroDocumento',
            'nombre',
            'primerApellido',
            'segundoApellido',
            'email:email',
            'telefono',
            'celular',
            'nitLaboratorio',
            'profesion',
            'fechaNacimiento',
            'Ciudad',
            'Direccion',
            'nombreLaboratorio',
            'idTercero',
            'idFabricante',
            'idAgrupacion',
            'nombreUnidadNegocio',
            
        ],
    ]) ?>
    <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form  name="permisos" id="permisos" action=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/ver?id=' . $model->numeroDocumento ?> " method="POST" >
        <?php foreach ($permisos as $nombre => $permiso ): ?>
            <label>
              <input type="checkbox" name="<?= $permiso; ?>" value=" <?= $permiso; ?> " <?php if( preg_match('/"'.$permiso.'"/i' , json_encode($permisosAsignados)) ){ echo "checked";} ?> >
              <?= $nombre; ?>
            </label>
        <?php endforeach; ?>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <input type="submit" value="Guardar">
      </form>
    </div>
</div>
    </div>
</div>
