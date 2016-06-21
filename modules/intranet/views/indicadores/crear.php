<?php

use yii\helpers\Html;

$this->title = 'Crea indicadores';

?>
<div class="indicadores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
