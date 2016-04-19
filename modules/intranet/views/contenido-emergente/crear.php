<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\ContenidoEmergente */

$this->title = 'Crea un Contenido Emergente';
//$this->params['breadcrumbs'][] = ['label' => 'Contenido Emergentes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contenido-emergente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
