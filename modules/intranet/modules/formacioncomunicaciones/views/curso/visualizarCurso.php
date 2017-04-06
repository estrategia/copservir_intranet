<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Curso */

$this->title = $model->nombreCurso;
$this->params['breadcrumbs'][] = ['label' => 'Mis Cursos', 'url' => ['mis-cursos']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curso-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>
        <?= $model->presentacionCurso ?>
    </h3>
    <?php if ($model->leido() != false && $model->cuestionario != null): ?>
      <?= Html::a('Tomar cuestionario', ['cuestionario/aplicar-cuestionario', 'id' => $model->cuestionario->idCuestionario], ['class' => 'btn btn-primary']) ?>
    <?php endif ?>

    <h1>Contenido</h1>
    <?= $this->render('_detalleContenidoCurso',['model' => $model]); ?>

</div>
