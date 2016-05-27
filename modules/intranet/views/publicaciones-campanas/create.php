<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\PublicacionesCampanas */

$this->title = 'Create Publicaciones Campanas';
$this->params['breadcrumbs'][] = ['label' => 'Publicaciones Campanas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publicaciones-campanas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
