<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\MenuPortales */

$this->title = 'Actualiza un menu de un portal: ';

?>
<div class="menu-portales-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProviderModuloContenido'=> $dataProviderModuloContenido
    ]) ?>

</div>
