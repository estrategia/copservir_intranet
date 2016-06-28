<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */

$this->title = 'Crear Ofertas Laborales';
$this->params['breadcrumbs'][] = ['label' => 'Ofertas laborales', 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => 'Crear oferta laboral'];
?>
<div class="ofertas-laborales-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    'destinoOfertasLaborales' => ''
    ]) ?>

  </div>
