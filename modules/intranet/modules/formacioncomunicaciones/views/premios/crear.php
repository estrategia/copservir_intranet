<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios */

$this->title = 'Crear Premio';
$this->params['breadcrumbs'][] = ['label' => 'Premios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-premios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
