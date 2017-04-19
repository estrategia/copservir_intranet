<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Curso */

$this->title = $model->nombreCurso;
$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curso-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>
        <?= $model->presentacionCurso ?>
    </h3>

    <h1>Contenido</h1>

    <?= $this->render('_detalleContenidoCurso',['model' => $model]); ?>

</div>
