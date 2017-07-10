<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\rating\StarRating;

$this->title = $model->tituloContenido;
$curso = $model->capitulo->modulo->curso;
$this->params['breadcrumbs'][] = ['label' => 'Mis Cursos', 'url' => ['curso/mis-cursos']];
// $this->params['breadcrumbs'][] = ['label' => $curso->nombreCurso];
$this->params['breadcrumbs'][] = ['label' => $curso->nombreCurso, 'url' => ['curso/visualizar-curso', 'id' => $curso->idCurso]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->session->has('success')): ?>
  <div class="alert alert-success" role="alert">
    <?= Yii::$app->session->getFlash('success') ?>
  </div>
<?php endif ?>
<?php if (Yii::$app->session->has('error')): ?>
  <div class="alert alert-danger" role="alert">
    <?= Yii::$app->session->getFlash('error') ?>
  </div>
<?php endif ?>

<div class="row">
  <div class="col-md-12">
    <h1><?= $model->tituloContenido?></h1>
    <?= $model->contenido; ?> <br>
        <?php if ($model->cuestionario != null): ?>
	      <?= Html::a('Prueba de conocimiento', ['cuestionario/aplicar-cuestionario', 'id' => $model->cuestionario->idCuestionario], ['class' => 'btn btn-primary']) ?>
	    <?php endif ?>
  </div>
</div>
<div id="marcador-leido" style="width: 10px; height: 10px;" data-contenido-id="<?= $model->idContenido ?>"></div>
<div class="row-eq-height" id="resumen-resenas-contenido">
  <div class="col-md-6">
    <div>
      <?php echo $this->render('resumen-resenas', ['datos' => $datos]); ?>
    </div>
  </div>
  <div class="col-md-6 crear-resena">
    <div>
      <?php 
        echo StarRating::widget([
            'name' => 'rating_1',
            'value' => $datos['promedio'],
            'pluginOptions' => [
              'displayOnly' => true,
              'showClear'=> false,
              'showCaption' => false,
              'filledStar' => '<i class="glyphicon glyphicon-star"></i>',
              'emptyStar' => '<i class="glyphicon glyphicon-star-empty"></i>',
            ]
        ]);
      ?>
      <button class="btn btn-default btn-block" data-toggle="modal" data-target="#modal-form-calificacion" <?php echo $calificacionModel->isNewRecord ? '' : 'disabled' ?> >Escribe una reseña</button>
    </div>
  </div>
</div>
<div class="row" id="comentarios-contenido">
  <?= ListView::widget([
        'dataProvider' => $dataProviderCalificacion,
        'options' => [
            'tag' => 'div',
            'class' => 'buscador-container',
            'id' => 'list-wrapper',
        ],
        'layout' => "{pager}\n{items}",
        'itemView' => '_item_calificacion',
        'pager' => [
            'nextPageLabel' => 'next',
            'prevPageLabel' => 'previous',
            'maxButtonCount' => 3,
        ],
    ]); ?>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-form-calificacion">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Escribe una reseña</h4>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin(); ?>

          <?= $form->field($calificacionModel, 'titulo')->textInput() ?>

          <?= $form->field($calificacionModel, 'comentario')->textArea(['rows' => '5']) ?>

          <?= $form->field($calificacionModel, 'calificacion')->widget(StarRating::classname(), [
            'pluginOptions' => [
              'step' => 1,
              'showClear'=> false,
              'showCaption' => false,
            ],
          ]); ?>

          <div class="form-group">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
          </div>
          
        <?php ActiveForm::end(); ?>

    
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->