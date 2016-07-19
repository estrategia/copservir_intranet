<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\AuthItem */

$this->title = 'Crea un rol';
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
