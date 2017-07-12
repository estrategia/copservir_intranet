<?php
use yii\helpers\Html;

$this->title = 'Crear Cuestionario';
$this->params['breadcrumbs'][] = ['label' => 'Cuestionarios', 'url' => ['/intranet/formacioncomunicaciones/cuestionario']];
$this->params['breadcrumbs'][] = ['label' => 'Crear Cuestionario'];
?>
<div class="linea-tiempo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
