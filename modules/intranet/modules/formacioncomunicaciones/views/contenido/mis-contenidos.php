<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Mis Contenidos';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        'tituloContenido',
        [
          'label' => 'Área de Conocimiento',
          'value' => function($model) {
            return $model->areaConocimiento->nombreArea;
          },
        ],
        [
          'label' => 'Capítulo',
          'value' => function($model) {
            return $model->capitulo->nombreCapitulo;
          },
        ],
        [
          'label' => 'Módulo',
          'value' => function($model) {
            return $model->modulo->nombreModulo;
          },
        ],
        [
          'label' => 'Leído',
          'value' => null
        ],
        [
          'label' => 'Preguntas',
          'value' => null
        ],
        [
          'label' => 'Visualizar',
          'format' => 'raw',
          'value' => function ($model) {                      
            return '<a href="'. Url::toRoute(['contenido/visualizar-contenido', 'id' => $model->idContenido]) .'"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></a>';
          },
        ]
      ],
]); ?>