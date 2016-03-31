<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\GrupoInteres */

$this->title = 'Actualizar Grupo Interes: ' . ' ' . $model->nombreGrupo;
//$this->params['breadcrumbs'][] = ['label' => 'Grupo Interes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->idGrupoInteres, 'url' => ['view', 'id' => $model->idGrupoInteres]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">
  <div class="grupo-interes-update">

      <h1><?= Html::encode($this->title) ?></h1>

      <?= $this->render('_form', [
          'model' => $model,
      ]) ?>

  </div>
</div>
