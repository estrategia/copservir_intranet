<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\MenuPortales */

$this->title = 'Crea un menu en un portal';

?>
<div class="menu-portales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProviderModuloContenido'=> $dataProviderModuloContenido
    ]) ?>

</div>
