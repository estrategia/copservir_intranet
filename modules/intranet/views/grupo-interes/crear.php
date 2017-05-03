<?php
use yii\helpers\Html;

$this->title = 'Crea un grupo de interes';
$this->params['breadcrumbs'][] = ['label' => 'Grupos de interés', 'url' => ['/intranet/grupo-interes/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Crear grupo'];

\yii\helpers\VarDumper::dump($padres, 10,true);
?>
<div class="col-md-12">
  <div class="grupo-interes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
      'model' => $model,
      'padres' => $padres
      ]) ?>

    </div>
  </div>
