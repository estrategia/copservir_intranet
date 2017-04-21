<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos */

$this->title = 'Crear Parametro';
$this->params['breadcrumbs'][] = ['label' => 'Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametros-puntos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
