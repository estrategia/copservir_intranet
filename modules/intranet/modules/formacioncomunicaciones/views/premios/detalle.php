<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios */

$this->title = $model->nombrePremio;
$this->params['breadcrumbs'][] = ['label' => 'Premios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-premios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idPremio], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idPremio',
            'nombrePremio',
            'descripcionPremio',
            'rutaImagen',
        /*   [
            	'attribute' => 	'estado',
            	'value' => function($modelo){return ($modelo->estado == 1)?'Activo':'Inactivo';},	
    		],
    		[
    		'attribute' => 	'idCategoria',
    		'value' => function($modelo){return $modelo->objCategoria->nombreCategoria;},
    		],*/
    		'fechaInicioVigencia',
    		'fechaFinVigencia',
            'fechaCreacion',
            'fechaActualizacion',
        ],
    ]) ?>

</div>
