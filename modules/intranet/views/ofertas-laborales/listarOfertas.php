<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Ofertas Laborales';
?>
<?php $time = new \DateTime('now');
        $today = $time->format('Y-m-d h:m:s');
        echo $today; ?>
<div class="ofertas-laborales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
        ],
        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'tituloOferta',
        	'nombreCargo',
        	[
        		'attribute' => 'idCiudad',
        		'value' => 'objCiudad.nombreCiudad',
        	],
        	'fechaCierre',
            // 'descripcionContactoOferta:ntext',
        	[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{link}',
                'buttons' => [
                   'link' => function ($url, $model, $key) {
                     return Html::a('Postularse', $model->urlElEmpleo, ['target' => '_blank', 'class' => 'btn btn-xs btn-primary ']);
                  },
                ],
            ],	
            
            
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
