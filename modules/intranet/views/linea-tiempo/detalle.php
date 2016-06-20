<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\LineaTiempo;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\LineaTiempo */

$this->title = 'detalle linea de tiempo';
//$this->params['breadcrumbs'][] = ['label' => 'Linea Tiempos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linea-tiempo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idLineaTiempo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idLineaTiempo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar esta linea de tiempo?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idLineaTiempo',
            'nombreLineaTiempo',
            'descripcion',
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == LineaTiempo::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
            [
              'attribute' => 'autorizacionAutomatica',
              'value' =>  $model->estado == LineaTiempo::AUTORIZACION_AUTOMATICA ? 'Si' : 'No',
            ],
            [
              'attribute' => 'tipo',
              'value' => ($model->tipo === LineaTiempo::TIPO_PUBLICACION) ? 'Publicación' :
                ($model->tipo === LineaTiempo::TIPO_CLASIFICADO ? 'Clasificado' :
                  ($model->tipo == LineaTiempo::TIPO_ANIVERSARIO ? 'Aniversario': '')),
            ],
            [
              'attribute' => 'solicitarGrupoObjetivo',
              'value' =>  $model->estado == LineaTiempo::TIENE_GRUPO_OBJETIVO ? 'Si' : 'No',
            ],
            'orden',
            'fechaInicio',
            'fechaFin',
            [
              'attribute' => 'color',
              'format'=>'raw',
              'value' => '<span class="badge" style="background-color: '.$model->color.'">&nbsp;</span>'

            ],
            [
              'attribute' => 'icono',
              'format'=>'raw',
              'value' => '<i class="'.$model->icono.'"></i>'
            ],
        ],
    ]) ?>

</div>
