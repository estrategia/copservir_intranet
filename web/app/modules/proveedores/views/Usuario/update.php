<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = 'Update Usuario Proveedor: ' . $model->numeroDocumento;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Proveedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numeroDocumento, 'url' => ['view', 'id' => $model->numeroDocumento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-proveedor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
