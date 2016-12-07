<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\Usuario */
// var_dump(Yii::$app->user->identity->confirmarDatosPersonales); exit();
$this->title = 'Mi Cuenta';
$this->params['breadcrumbs'][] = $this->title;
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

        <?php if(Yii::$app->user->identity->confirmarDatosPersonales == 0): ?>

            <form class="text-center" name="terminos" id="terminos" action=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/usuario/aceptar-terminos'?> " method="POST" >
                <h1>
                    <label for="confirmarDatosPersonales">Acepto los términos y condiciones</label><br>
                    <small>
                        <a href=" <?php echo Yii::$app->getUrlManager()->getBaseUrl() . Yii::$app->params['habeasDataLink']; ?> ">Ver términos</a>
                    </small>
                </h1>
                <input type="checkbox" name="confirmarDatosPersonales" id="confirmarDatosPersonales" value="1">
                <br><br>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="submit" value="Aceptar" class="btn btn-primary">
            </form>

            <div class="space-2"></div>        

        <?php else: ?>

            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a('Actualizar', ['actualizar-mi-cuenta'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Cambiar contraseña', ['cambiar-clave'], ['class' => 'btn btn-primary']) ?>
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
                    'nombreLaboratorio',
                    'profesion',
                    'fechaNacimiento',
                    'Ciudad',
                    'Direccion',
                ],
            ]) ?>

        <?php endif; ?>
    </div>
</div>
