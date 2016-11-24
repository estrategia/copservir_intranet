<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = $model->nombre . ' ' . $model->primerApellido;
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
            <div class="col-md-12">
            <h1>Acceso a portales</h1>
              <form  name="permisos" id="permisos" action=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/ver?id=' . $model->numeroDocumento ?> " method="POST" >
                <table class="table table-striped table-bordered">
                    <!-- <thead>
                        <tr>
                            <th colspan="2"></th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <?php foreach ($permisos as $nombre => $permiso ): ?>
                            <tr>
                              <td>
                                <strong>
                                    <?= $nombre; ?>
                                </strong>
                              </td>
                              <td>
                                <input type="checkbox" name="<?= $permiso; ?>" value=" <?= $permiso; ?> " <?php if( preg_match('/"'.$permiso.'"/i' , json_encode($permisosAsignados)) ){ echo "checked";} ?> >
                                  
                              </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="submit" value="Guardar permisos" class="btn btn-primary">
              </form>
            </div>
        </div>
        <div class="space-1"></div>
    </div>
</div>
