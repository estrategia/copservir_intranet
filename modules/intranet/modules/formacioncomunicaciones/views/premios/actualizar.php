<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios */

$this->title = 'Actualizar Categoría: ' . $model->nombrePremio;
$this->params['breadcrumbs'][] = ['label' => 'Premios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombrePremio, 'url' => ['detalle', 'id' => $model->idPremio]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="categorias-premios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
