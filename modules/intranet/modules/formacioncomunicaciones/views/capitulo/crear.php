<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CapituloContenido */

$this->title = 'Crear Capítulo de Interés';
$this->params['breadcrumbs'][] = ['label' => 'Capítulo de Interés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capitulo-contenido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
