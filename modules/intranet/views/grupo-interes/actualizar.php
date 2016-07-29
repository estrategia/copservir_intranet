<?php
use yii\helpers\Html;

$this->title = 'Actualizar grupo';
$this->params['breadcrumbs'][] = ['label' => 'Grupos de interés', 'url' => ['/intranet/grupo-interes/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Actualizar grupo'];
?>
<div class="col-md-12">
  <div class="grupo-interes-update">

    <h1><?= Html::encode($model->nombreGrupo) ?></h1>

    <?= $this->render('_form', [
      'model' => $model,
      ]) ?>

  </div>
</div>
