<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Contenido */

$this->title = 'Actualizar Contenido';
$this->params['breadcrumbs'][] = ['label' => 'Contenidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idContenido, 'url' => ['detalle', 'id' => $model->idContenido]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="contenido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'areas' => $areas,
        'modulos' => $modulos,
        'capitulos' => $capitulos,
        'tipos' => $tipos
    ]) ?>

</div>
