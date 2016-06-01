<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\LineaTiempo */

$this->title = 'Crea una linea de tiempo';
//$this->params['breadcrumbs'][] = ['label' => 'Linea Tiempos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linea-tiempo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
