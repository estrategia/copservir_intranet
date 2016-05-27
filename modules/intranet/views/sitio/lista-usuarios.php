<?php
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div id="listaOfertas">

  <?=  GridView::widget([
    'dataProvider' => $dataProviderUsuarios,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      [
        'attribute' => 'imagenPerfil',
        'format'=>'raw',
        'value' => function($model) {
          return '<img src="'.Yii::getAlias('@web').'/img/fotosperfil/'. $model->imagenPerfil.'" class="img-circle img-responsive" style="width: 10%;"/>';
        }
      ],
      'alias',
      [
        'class' => 'yii\grid\ActionColumn',
        'headerOptions'=> ['style'=>'width: 70px;'],
        'template' => '{ver-permisos}',
        'buttons' => [
          'ver-permisos' => function ($url, $modelUsuario) {
            return  Html::a('ver permisos',
            ['permisos-usuario', 'id'=>$modelUsuario->numeroDocumento],
            [
              'class' => 'btn btn-primary',
            ]
          );
        }
      ],
    ],
  ],
]); ?>

</div>
