<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CapituloContenido */

$this->title = 'Actualizar Capítulo de Interés';
$this->params['breadcrumbs'][] = ['label' => 'Capítulo de Interés', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombreCapitulo, 'url' => ['detalle', 'id' => $model->idCapitulo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="capitulo-contenido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
