<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\PublicacionesCampanas;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\PublicacionesCampanas */

$this->title = 'Detalle campaña';
//$this->params['breadcrumbs'][] = ['label' => 'Publicaciones Campanas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publicaciones-campanas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idImagenCampana], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idImagenCampana], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar esta Campaña?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idImagenCampana',
            'nombreImagen',
            [
              'attribute' => 'rutaImagen',
              'format'=>'raw',
              'value' => '<img src="'.Yii::getAlias('@web').'/img/campanas/'. $model->rutaImagen.'" class="img-responsive"
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
