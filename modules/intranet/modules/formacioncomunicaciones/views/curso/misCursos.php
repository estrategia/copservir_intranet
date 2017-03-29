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
          'attribute' => '',
          'format' => 'raw',
          'value' => function ($model) {                      
              return '<a class="btn btn-default" href="'. Url::to(['visualizar-curso', 'id' => $model->idCurso]) .'">Visualizar</a>';
          },
        ],
      ],
]); ?>