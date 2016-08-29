<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\Espacio */

$this->title = 'Actualiza un espacio:';
// $this->params['breadcrumbs'][] = ['label' => 'Espacios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->idEspacio, 'url' => ['view', 'id' => $model->idEspacio]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="space-1"></div>
<div class="space-2"></div>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<div class="space-1"></div>
<div class="space-2"></div>
