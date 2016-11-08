<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\PublicacionesCampanas;

$this->title = 'Ver publicidad';
$this->params['breadcrumbs'][] = ['label' => 'Publicidad', 'url'=>['/intranet/publicaciones-campanas/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Ver publicidad'];
?>
<div class="publicaciones-campanas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idImagenCampana], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idImagenCampana], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar esta publicidad?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombreImagen',
            [
              'attribute' => 'rutaImagen',
              'format'=>'raw',
              'value' => '<img src="'.Yii::getAlias('@web').'/img/campanas/'. $model->rutaImagen.'" class="img-responsive"
                style="width: 22%;"/>'

            ],
            [
              'attribute' => 'rutaImagenResponsive',
              'format'=>'raw',
              'value' => '<img src="'.Yii::getAlias('@web').'/img/campanas/'. $model->rutaImagenResponsive.'" class="img-responsive"
                style="width: 22%;"/>'

            ],
            [
              'label'=>'Enlace a noticia',
              'attribute'=>'urlEnlaceNoticia:url',
              'format'=>'raw',
              'value' => $model->urlEnlaceNoticia ?
                  Html::a('<span class="glyphicon glyphicon-link" aria-hidden="true"></span>', $model->urlEnlaceNoticia, []) :'No tiene enlace',
            ],
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == PublicacionesCampanas::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
            [
              'attribute' => 'posicion',
              'value' => ($model->posicion === PublicacionesCampanas::POSICION_ARRIBA) ? 'Superior' :
                ($model->posicion === PublicacionesCampanas::POSICION_ABAJO ? 'Inferior' :
                  ($model->posicion == PublicacionesCampanas::POSICION_DERECHA ? 'Derecha': '')),
            ],
            'fechaInicio',
            'fechaFin',
        ],
    ]) ?>

</div>
