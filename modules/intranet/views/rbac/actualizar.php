<?php
use yii\helpers\Html;

$this->title = 'Actualizar rol';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Detalle de rol', 'url' => ['detalle', 'id' => $model->name]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
