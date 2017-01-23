<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\Usuario */

$this->title = 'Mi cuenta';
// $this->params['breadcrumbs'][] = ['label' => 'Mi cuenta'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?= Html::encode($this->title) ?></h3>
                </div>
            </div>
            <div class="panel-body">    
                <p>
                    <?= Html::a('Actualizar', ['actualizar-mi-cuenta'], ['class' => 'btn btn-primary']) ?>
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
                        [
                            'attribute' => 'Ciudad',
                            'format' => 'raw',
                            'value' => (isset($model->objCiudad) ? $model->objCiudad->nombreCiudad : null),
                        ],
                        'Direccion',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
