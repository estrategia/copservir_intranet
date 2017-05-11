<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\PortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'idPortal',
            'nombrePortal',
            'colorPortal',
            'logoPortal',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
