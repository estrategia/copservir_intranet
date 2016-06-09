<?php

use yii\helpers\Html;

$this->title = 'Actualiza un evento';

?>
<div class="evento-calendario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'destinoEventosCalendario' => $destinoEventosCalendario,
        'modelDestinoEventos' => $modelDestinoEventos
    ]) ?>

</div>
