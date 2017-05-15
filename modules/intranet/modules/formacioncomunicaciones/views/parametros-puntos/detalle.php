<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos */

$this->title = $model->idParametroPunto;
$this->params['breadcrumbs'][] = ['label' => 'Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametros-puntos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idParametroPunto], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idParametroPunto',
            'tipoParametro',
            'valorPuntos',
            'idTipoContenido',
            'condicion',
            'estado',
            'fechaCreacion',
            'fechaActualizacion',
            'valorPuntosExtra',
        ],
    ]) ?>

</div>
