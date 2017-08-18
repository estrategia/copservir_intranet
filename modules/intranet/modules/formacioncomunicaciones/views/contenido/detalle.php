<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Contenido */

$this->title = $model->tituloContenido;
$curso = $model->capitulo->modulo->curso;
$this->params['breadcrumbs'][] = ['label' => 'Mis Cursos', 'url' => ['curso/mis-cursos']];
// $this->params['breadcrumbs'][] = ['label' => $curso->nombreCurso];
$this->params['breadcrumbs'][] = ['label' => $curso->nombreCurso, 'url' => ['curso/visualizar-curso', 'id' => $curso->idCurso]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contenido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idContenido], ['class' => 'btn btn-primary']) ?>
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
                'label' => 'Capítulo',
                'value' => $model->capitulo->nombreCapitulo
            ],
            // 'idContenidoCopia',
            'frecuenciaMes',
            'cantidadPuntos'
        ],
    ]) ?>

</div>
