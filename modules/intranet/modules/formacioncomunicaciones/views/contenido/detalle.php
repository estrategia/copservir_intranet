<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Contenido */

$this->title = $model->tituloContenido;
$this->params['breadcrumbs'][] = ['label' => 'Contenidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contenido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idContenido], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idContenido], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de querer eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tituloContenido',
            'descripcionContenido',
            'contenido:ntext',
            [
                'label' => 'Estado',
                'value' => $model->estadoContenido == 1 ? 'Activo' : 'Inactivo'
            ],
            [
                'label' => 'Área de Conocimiento',
                'value' => $model->areaConocimiento->nombreArea
            ],
            [
                'label' => 'Módulo',
                'value' => $model->modulo->nombreModulo
            ],
            [
                'label' => 'Capítulo',
                'value' => $model->capitulo->nombreCapitulo
            ],
            [
                'label' => 'Tipo de Contenido',
                'value' => $model->tipoContenido->nombreTipoContenido
            ],
            'idContenidoCopia',
            'fechaInicio',
            'fechaFin',
            'frecuenciaMes',
        ],
    ]) ?>

</div>
