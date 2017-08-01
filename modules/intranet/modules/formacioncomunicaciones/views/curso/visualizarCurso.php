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
    <!-- $model->cuestionario != null -->
    <?php if ($model->cuestionario != null): ?>
        <?php if ($model->cuestionario->estado == 1): ?>
            <?= Html::a('Prueba de conocimiento', ['cuestionario/aplicar-cuestionario', 'id' => $model->cuestionario->idCuestionario], ['class' => 'btn btn-primary']) ?>
        <?php endif ?>
    <?php endif ?>

    <h1>Contenido</h1>
    <?= $this->render('_detalleContenidoCurso', ['model' => $model]); ?>
</div>

<?php //yii\helpers\VarDumper::dump($model->getModulosActivosUsuario(),1,true) ?>
