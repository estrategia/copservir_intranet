<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\Categoria */

$this->title = 'Actualizar categoria';
//$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->idCategoria, 'url' => ['view', 'id' => $model->idCategoria]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="space-1"></div>
<div class="space-2"></div>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<div class="space-1"></div>
<div class="space-2"></div>
