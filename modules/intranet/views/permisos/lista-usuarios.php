<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Permisos de usuarios'];
?>
<div id="listaOfertas">

    <?=
    GridView::widget([
        'dataProvider' => $dataProviderUsuarios,
        'filterModel' => $searchModel,
        'pager' => [
          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
        ],
        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
        'columns' => [
            'numeroDocumento',

            [
                'attribute' => 'imagenPerfil',
                'format' => 'raw',
                'value' => function($model) {
                    return '<img src="' . Yii::getAlias('@web') . '/img/fotosperfil/' . $model->getImagenPerfil() .
                      '" class="img-circle img-responsive" style="width: 10%;"/>';
                }
            ],
            'alias',
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width: 70px;'],
                'template' => '{ver-permisos}',
                'buttons' => [
                    'ver-permisos' => function ($url, $modelUsuario) {
                        return Html::a('ver permisos', ['usuario', 'id' => $modelUsuario->numeroDocumento], ['class' => 'btn btn-primary']);
                    }
                        ],
                    ],
                ],
            ]);
    ?>

</div>
