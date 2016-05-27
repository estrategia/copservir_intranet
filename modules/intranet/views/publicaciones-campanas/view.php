<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\PublicacionesCampanas */

$this->title = $model->idImagenCampana;
$this->params['breadcrumbs'][] = ['label' => 'Publicaciones Campanas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publicaciones-campanas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idImagenCampana], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idImagenCampana], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idImagenCampana',
            'nombreImagen',
            'rutaImagen',
            'numeroDocumento',
            'urlEnlaceNoticia:url',
            'fechaInicio',
            'estado',
            'posicion',
            'fechaFin',
        ],
    ]) ?>

</div>
