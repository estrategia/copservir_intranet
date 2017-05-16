<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parametros - Puntos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametros-puntos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= Html::a("Parametros", Url::to(['parametros']), ['class' => 'btn btn-default']) ?>
    <?= Html::a("Puntos", Url::to(['puntos']), ['class' => 'btn btn-default']) ?>

    </div>
</div>
