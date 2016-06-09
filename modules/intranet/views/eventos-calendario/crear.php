<?php

use yii\helpers\Html;

$this->title = 'Crea un evento';

?>
<div class="evento-calendario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form',
      [
        'model' => $model,
      ])
    ?>
</div>
