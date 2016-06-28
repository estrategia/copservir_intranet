<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\InformacionContactoOferta */

$this->title = 'Actualiza la plantilla ';
$this->params['breadcrumbs'][] = ['label' => 'Plantilla ofertas laborales', 'url' => ['/intranet/informacion-contacto-oferta/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Actualizar plantilla'];
?>
<div class="informacion-contacto-oferta-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

  </div>
