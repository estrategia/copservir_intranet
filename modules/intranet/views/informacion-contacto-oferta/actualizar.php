<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\InformacionContactoOferta */

$this->title = 'Actualiza la plantilla ';
//$this->params['breadcrumbs'][] = ['label' => 'Informacion Contacto Ofertas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->idInformacionContacto, 'url' => ['view', 'id' => $model->idInformacionContacto]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="informacion-contacto-oferta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
