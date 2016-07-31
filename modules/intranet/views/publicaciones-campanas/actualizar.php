<?php
use yii\helpers\Html;

$this->title = 'Actualizar publicidad';
$this->params['breadcrumbs'][] = ['label' => 'Publicidad', 'url'=>['/intranet/publicaciones-campanas/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Actualizar publicidad'];
?>
<div class="publicaciones-campanas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'destinoCampanas' => $destinoCampanas,
        'modelDestinoCampana' => $modelDestinoCampana
    ]) ?>

</div>
