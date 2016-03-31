<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\GrupoInteres */

$this->title = 'Crea un grupo de interes';
//$this->params['breadcrumbs'][] = ['label' => 'Grupo Interes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
  <div class="grupo-interes-create">

      <h1><?= Html::encode($this->title) ?></h1>

      <?= $this->render('_form', [
          'model' => $model,
      ]) ?>

  </div>
</div>
