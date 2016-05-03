<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */

$this->title = 'Actualizar Ofertas Laborales: ';
$this->params['breadcrumbs'][] = ['label' => 'Ofertas Laborales', 'url' => ['index']];
?>
<div class="ofertas-laborales-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    'destinoOfertasLaborales' => $destinoOfertasLaborales
    ]) ?>

  </div>
