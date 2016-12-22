<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\Usuario */

$this->title = 'Actualizar mi Cuenta';
$this->params['breadcrumbs'][] = ['label' => 'Mi Cuenta', 'url' => ['mi-cuenta']];
$this->params['breadcrumbs'][] = 'Actualizar mi cuenta';
?>
<div class="container">
  <div class="row">
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

   <!--  <?php if(Yii::$app->user->identity->confirmarDatosPersonales == 0): ?>
      <div class="row">
        <div class="form-header">
          <h4>Términos y condiciones <small>(Recuerde que para hacer uso del portal colaborativo debe aceptar los términos y condiciones)</small></h4>
        </div>
          <form class="text-center" name="terminos" id="terminos" action=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/aceptar-terminos'?> " method="POST" >
              <div class="form-group">
                <label class="pull-left" for="confirmarDatosPersonales">Acepto los términos y condiciones</label>
                <input type="checkbox" name="confirmarDatosPersonales" id="confirmarDatosPersonales">
              </div>
              <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
              <input type="submit" value="Aceptar términos
              " class="btn btn-primary pull-right">
            <a class="pull-left" href=" <?php echo Yii::$app->getUrlManager()->getBaseUrl() . Yii::$app->params['habeasDataLink']; ?> ">Ver términos</a>
          </form>
      </div>
    <?php endif; ?> -->


    <h1><?= Html::encode($this->title) ?></h1>
    <p>Recuerde actualizar la información personal, información de contacto y la política de tratamiento de datos para acceder a los servicios del Portal Colaborativo de Copservir Ltda.<p>
    <?= $this->render('_formMiCuenta', [
        'model' => $model,
        'ciudades' => $ciudades,
        'profesiones' => $profesiones,
    ]) ?>
  </div>
</div>
