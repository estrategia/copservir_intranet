<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\PublicacionesCampanas */

$this->title = 'Actualiza una Campaña Publicitaria';
//$this->params['breadcrumbs'][] = ['label' => 'Publicaciones Campanas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->idImagenCampana, 'url' => ['view', 'id' => $model->idImagenCampana]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="publicaciones-campanas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
