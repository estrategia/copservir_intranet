<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Portal */

$this->title = $model->nombrePortal;
$this->params['breadcrumbs'][] = ['label' => 'Portales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idPortal], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idPortal',
            'nombrePortal',
            'estado',
            'colorPortal',
            [
                'label' => 'Logo',
                'value' => Yii::getAlias('@web') . '/img/multiportal/' . $model->nombrePortal . '/' . $model->logoPortal,
                'format' => ['image']
            ]
        ],
    ]) ?>

</div>
