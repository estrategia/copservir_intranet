<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Documento */

$this->title = 'Crea un Documento';
$this->params['breadcrumbs'][] = ['label' => 'Documentos organizacionales', 'url' => ['/intranet/documento/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Crear documento'];
?>
<div class="documento-create">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

  </div>
