<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Contenido */
$capitulo = $model->capitulo;
$modulo = $capitulo->modulo;
// var_dump($capitulo);
$curso = $modulo->curso;
$this->title = 'Actualizar Contenido';
$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['curso/index']];
$this->params['breadcrumbs'][] = ['label' => $curso->nombreCurso, 'url' => ['curso/actualizar', 'id' => $curso->idCurso]];
$this->params['breadcrumbs'][] = '  Contenido';
$this->params['breadcrumbs'][] = ['label' => $model->tituloContenido, 'url' => ['visualizar-contenido', 'id' => $model->idContenido]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="contenido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'capitulos' => $capitulos
    ]) ?>

</div>
