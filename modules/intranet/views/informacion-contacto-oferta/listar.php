<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\InformacionContactoOfertaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plantillas';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacion-contacto-oferta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crea una plantilla', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idInformacionContacto',
            'nombrePlantilla',
            'plantillaContactoHtml:ntext',
            //'estado',
            'fechaRegistro',
            //'numeroDocumento',

            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle} {actualizar} {eliminar}',
              'buttons' => [
                  'detalle' => function ($url, $model) {
                      return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                  },
                  'actualizar' => function ($url, $model) {
                      return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                  },
                  'eliminar' => function ($url, $model) {
                      return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                  }
              ],
            ],
        ],
    ]); ?>
</div>
