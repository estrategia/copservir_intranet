<?php

use yii\helpers\Html;

$this->title = 'Crea un evento';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Eventos calendario'), 'url' => ['/intranet/calendario/admin']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Crear evento')];
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
