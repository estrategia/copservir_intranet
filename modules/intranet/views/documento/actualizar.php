<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Documento */

$this->title = 'Actualizar el Documento: ' . $model->titulo;
//$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->idDocumento, 'url' => ['view', 'id' => $model->idDocumento]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
