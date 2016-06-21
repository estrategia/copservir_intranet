<?php

use yii\helpers\Html;

$this->title = 'Actualiza un indicador';

?>
<div class="indicadores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
