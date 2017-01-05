<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = $model->nombre . ' ' . $model->primerApellido;
$this->params['breadcrumbs'][] = ['label' => 'Gestión de Usuarios', 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>
                  <?= Yii::$app->session->getFlash('error') ?>
                </strong>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>
                  <?= Yii::$app->session->getFlash('success') ?>
                </strong>
            </div>
        <?php endif; ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="form-header">
        </div>
        <div class="row">
            <div class="col-md-12">
            <h1>Servicios del Portal Colaborativo</h1>
              <form  name="permisos" id="permisos" action=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/ver?id=' . $model->numeroDocumento ?> " method="POST" >
                <table class="table table-striped table-bordered">
                    <!-- <thead>
                        <tr>
                            <th colspan="2"></th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <?php $indice = 0 ?>
                        <?php foreach ($permisos as $nombre => $permiso ): ?>
                          <?php $indice++; ?>
                            <tr>
                              <td>
                                <?php echo $indice; ?>
                              </td>
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
                <input type="submit" value="Guardar Permisos" class="btn btn-primary">
              </form>
            </div>
        </div>
        <div class="space-1"></div>
        <h1>Información del Usuario</h1>
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
                'nombreLaboratorio',
                'profesion',
                'fechaNacimiento',
                'Ciudad',
                'Direccion',
                // 'idTercero',
                // 'idFabricante',
                // 'idAgrupacion',
                // 'nombreUnidadNegocio',
                
            ],
        ]) ?>
        <p>
            <?= Html::a('Actualizar', ['actualizar', 'id' => $model->numeroDocumento], ['class' => 'btn btn-primary']) ?>
        </p>
        <div class="space-1"></div>
    </div>
</div>
