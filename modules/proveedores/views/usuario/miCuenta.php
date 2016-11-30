<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\Usuario */

$this->title = 'Mi Cuenta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
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
    </div>
</div>
