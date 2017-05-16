<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\CursoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Redenciones';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mis-reedenciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'Icon',
                'format' => 'html',
                'label' => '',
                'value' => function ($data) {
                return Html::img(\Yii::getAlias('@web'). '/img/formacioncomunicaciones/premios/' . $data->objPremio->rutaImagen,
                   ['width' => '60px']);
                },
            ],

            [
                'attribute' => 'Premio',
                'format' => 'raw',
                'value' => 'objPremio.nombrePremio',
                'filter' => Html::activeTextInput($searchModel, 'nombrePremio')
            ],

            [
                'attribute' => 'objUsuario',
                'label' => 'Usuario',
                'value' => 'objUsuario.nombres',
                'filter' => Html::activeInput('text', $searchModel, 'usuario'),
            ],
            
            'fechaCreacion',
        ],
    ]); ?>
</div>
