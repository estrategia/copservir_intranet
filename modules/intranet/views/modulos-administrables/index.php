<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Modulos Contenidos');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Intranet'), 'url' => [Yii::$app->session['layoutConfiguracion'].'/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">

    <p>
        <?= Html::a(Yii::t('app', 'Crear Modulo'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'titulo',
            'tipo',
            'descripcion',
            'contenido',
//            [
//                'attribute' => 'IdOrigenCaso',
//                'label' => 'Origen Caso',
//                'format' => 'text',
//                'content' => function($data) {
//                    return $data->idOrigenCaso->DescripcionOrigenCaso . " -- " . $data->idOrigenCaso->idConceptoCaso->DescripcionConceptoCaso;
//                },
//            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
        'options' => [
            'class' => 'table-responsive'
        ]
    ]);
    ?>

</div>
