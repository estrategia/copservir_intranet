<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenido */

$this->title = 'Actualizar Tipo de Contenido';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Contenidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombreTipoContenido, 'url' => ['detalle', 'id' => $model->idTipoContenido]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipo-contenido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
