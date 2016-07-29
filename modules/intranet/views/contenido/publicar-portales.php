<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\Contenido;

$this->title = 'Noticias de portales';
$this->params['breadcrumbs'][] = ['label' => 'Noticias de portales'];
?>
<div class="linea-tiempo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea un contenido', ['publicar-portales-crear'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'titulo',
            'fechaPublicacion',
            [
              'attribute' => 'estado',
              'value' => function($model) {
                if ($model->estado == Contenido::APROBADO ) {
                  return 'Aprobado';
                }
                if ($model->estado == Contenido::ELIMINADO ) {
                  return 'Inactivo';
                }
                if ($model->estado == Contenido::ELIMINADO_DENUNCIO ) {
                  return 'Aniversario';
                }
                if ($model->estado == Contenido::PENDIENTE_APROBACION ) {
                  return 'Pendiente de aprobacion';
                }
              }
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{publicar-portales-actualizar}',
              'buttons' => [
                'publicar-portales-actualizar' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                },
              ],
            ],
        ],
    ]); ?>
</div>
