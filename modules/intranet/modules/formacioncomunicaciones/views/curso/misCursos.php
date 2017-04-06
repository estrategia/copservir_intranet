<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Mis Cursos';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        'nombreCurso',
        'presentacionCurso',
        [
          'attribute' => 'Leído',
          'format' => 'raw',
          'value' => function ($model) {                      
              return $model->leido() == false ? '<span class="glyphicon glyphicon-remove"></span>' : '<span class="glyphicon glyphicon-ok"></span>';
          },
        ],
        [
          'attribute' => '',
          'format' => 'raw',
          'value' => function ($model) {                      
              return '<a class="btn btn-default" href="'. Url::to(['visualizar-curso', 'id' => $model->idCurso]) .'">Visualizar</a>';
          },
        ]
      ],
]); ?>