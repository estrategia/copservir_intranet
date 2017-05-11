<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\GrupoInteres;

$this->title = 'Grupos de interes';
$this->params['breadcrumbs'][] = ['label' => 'Grupos de interés'];
?>
<div class="grupo-interes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear un grupo de interes', ['crear'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
        ],
        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
        'columns' => [
            'idGrupoInteres',
            'nombreGrupo',
            [
                'attribute' => 'estado',
                'filter' =>
                Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'], ['class' => 'form-control', 'prompt' => 'Seleccione']),
                'value' => function($model) {
                    if ($model->estado == GrupoInteres::ESTADO_ACTIVO) {
                        return 'Activo';
                    } else {
                        return 'Inactivo';
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width: 70px;'],
                'template' => '{detalle} {actualizar} {eliminar}',
                'buttons' => [
                    'detalle' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    },
                    'actualizar' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    },
                    'eliminar' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                    }
                ],
            ],
        ],
    ]);
    ?>

</div>
