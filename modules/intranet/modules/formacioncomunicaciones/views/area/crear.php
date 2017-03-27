<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\AreaContenido */

$this->title = 'Crear Área de Interés';
$this->params['breadcrumbs'][] = ['label' => 'Áreas de Interés', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-contenido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
