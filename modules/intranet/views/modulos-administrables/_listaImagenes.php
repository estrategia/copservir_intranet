<?php 
use yii\helpers\Html;
use \yii\grid\GridView;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
          'label' => 'Imagen',
          'format' => 'html',
          'value' => function ($model) {
            return Html::img($model->getUrlImagen(), ['class' => 'img-thumbnail']);
          }
        ],
        'nombreImagen',
        'rutaImagen',
        'orden',
        [
          'label' => 'Editar',
          'format' => 'raw',
          'value' => function ($model) {                      
              return '<button class="btn btn-default" data-imagen="' . $model->idImagenModuloGaleria . '" data-modulo="' . $model->idModulo . '" data-role="editar-imagen-modulo-galeria">Editar imagen</button>';
            },
        ],  
        [
          'label' => 'Eliminar',
          'format' => 'raw',
          'value' => function ($model) {                      
              return '<button class="btn btn-danger" data-imagen="' . $model->idImagenModuloGaleria . '" data-modulo="' . $model->idModulo . '" data-role="eliminar-imagen-modulo-galeria">Eliminar imagen</button>';
            },
        ],
    ],
]); ?>
