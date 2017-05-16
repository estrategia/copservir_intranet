<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Curso */

$this->title = 'Actualizar Curso: ' . $model->nombreCurso;
$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombreCurso, 'url' => ['detalle', 'id' => $model->idCurso]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="curso-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#curso" aria-controls="curso" role="tab" data-toggle="tab">Curso</a></li>
    <li role="presentation"><a href="#contenidos" aria-controls="contenidos" role="tab" data-toggle="tab">Contenidos</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="curso">
      <?= $this->render('_form', [
          'model' => $model,
          'gruposInteres' => $gruposInteres,
          'tiposContenido' => $tiposContenido,
          'objCursoGruposInteres' => $objCursoGruposInteres
      ]) ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="contenidos">
      <p>
        <button type="button" name="button" class="btn btn-success" data-role="modulo-crear" data-curso="<?php echo $model->idCurso; ?> ">Crear modulo</button>
      </p>
      <?= $this->render('_contenidoCurso', [
        'model' => $model,
      ]) ?>
    </div>
  </div>

</div>
